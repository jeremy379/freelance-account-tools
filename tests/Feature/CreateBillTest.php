<?php

namespace Tests\Feature;

use Module\Balance\Domain\Balance;
use Module\Billing\Application\CreateBillCommand;
use Module\Billing\Application\CreateBillCommandHandler;
use Module\Billing\Application\ReceiveBillPaymentCommand;
use Module\Billing\Application\ReceiveBillPaymentCommandHandler;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Events\BillPaid;
use Module\Billing\Domain\Exception\CannotCreateBill;
use Module\Billing\Domain\Objects\TaxRate;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\Billing\Infrastructure\Repository\BillDomainFactory;
use Module\Billing\Infrastructure\Repository\BillRepositoryDatabase;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Domain\EventDispatcher;
use Tests\FakeClock;
use Tests\FakeEventDispatcher;
use Tests\TestCase;

class CreateBillTest extends TestCase
{
    private EventDispatcher $eventDispatcher;
    private BillRepository $billRepository;
    private ClockInterface $clock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->billRepository = new BillRepositoryDatabase(new BillDomainFactory());
        $this->clock = new FakeClock();
    }

    public function testItRecordsExpense()
    {
        $command = new CreateBillCommand(
            $reference = 'bill_2023-001',
            'client_1',
            500.25,
            21,
            $this->clock->now()
        );

        $commandHandler = new CreateBillCommandHandler(
            $this->billRepository
        );

        $commandHandler->handle($command);

        $billingInDb = EloquentBill::where('reference', $reference)->first();

        $this->assertNotNull($billingInDb);
        $this->assertDatabaseHas(EloquentBill::class, [
            'reference' => $reference,
            'client' => 'client_1',
            'amount' => 50025,
            'tax_rate' => 21,
            'billing_datetime' => $this->clock->now(),
        ]);
    }

    public function testBillPaymentEmitEvent()
    {
        $taxRate = TaxRate::rate21();
        EloquentBill::factory(['reference' => 'bill_2023-002', 'tax_rate' => $taxRate->taxRatePercentage])->create();

        $command = new ReceiveBillPaymentCommand(
            $reference = 'bill_2023-002',
            $amount = 500.54,
            $this->clock->now(),
        );

        $commandHandler = new ReceiveBillPaymentCommandHandler(
            $this->billRepository,
            $this->eventDispatcher
        );

        $commandHandler->handle($command);

        $expenseInDb = Balance::where('reference', $reference)->first();

        $this->assertNotNull($expenseInDb);
        $this->assertEquals(50054, $expenseInDb->amount);

        $this->eventDispatcher->assertEmitted(new BillPaid($reference, ($amount + ($amount * $taxRate/100)) * 100, $this->clock->now()));
    }

    public function testItFailsWhenExpenseReferenceAlreadyExists()
    {
        EloquentBill::factory(['reference' => 'bill_2023-002',])->create();

        $command = new CreateBillCommand(
             'bill_2023-002',
            'client_1',
            500.25,
            21,
            $this->clock->now()
        );

        $commandHandler = new CreateBillCommandHandler(
            $this->billRepository
        );

        $this->expectException(CannotCreateBill::class);
        $commandHandler->handle($command);
    }
}
