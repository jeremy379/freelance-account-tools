<?php

namespace Tests\Feature;

use Module\Balance\Application\CreateBillCommand;
use Module\Balance\Application\CreateBillCommandHandler;
use Module\Balance\Application\ReceiveBillPaymentCommand;
use Module\Balance\Application\ReceiveBillPaymentCommandHandler;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Events\BillPaid;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\Billing\Infrastructure\Repository\BillRepositoryDatabase;
use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Application\CreateExpenseCommandHandler;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\Expense\Domain\Exception\CannotCreateExpense;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
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
        $this->billRepository = new BillRepositoryDatabase();
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
        EloquentBill::factory(['reference' => 'bill_2023-002'])->create();

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

        $expenseInDb = EloquentBill::where('reference', $reference)->first();

        $this->assertNotNull($expenseInDb);

        $this->eventDispatcher->assertEmitted(new BillPaid($reference, ($amount + ($amount * $taxRate/100)) * 100, $this->clock->now()));
    }

    public function testItFailsWhenExpenseReferenceAlreadyExists()
    {
        $command = new CreateBillCommand(
            $reference = 'expense-002',
            'car',
            'company-1',
            $amount = 500.54,
            $taxRate = 21,
            'BE',
            $this->clock->now(),
        );

        $commandHandler = new CreateExpenseCommandHandler(
            $this->expenseRepository,
            $this->eventDispatcher
        );


        $commandHandler->handle($command);

        $this->expectException(CannotCreateExpense::class);
        $commandHandler->handle($command);
    }
}
