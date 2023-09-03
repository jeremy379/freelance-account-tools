<?php

namespace Tests\Feature;

use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Balance\Infrastructure\Listener\BalanceEventSubscriber;
use Module\Balance\Infrastructure\Repository\BalanceRepositoryDatabase;
use Module\Billing\Domain\Events\BillPaid;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Domain\EventDispatcher;
use Module\SharedKernel\Infrastructure\LaravelEventDispatcher;
use Tests\FakeClock;
use Tests\TestCase;

class BalanceListenerTest extends TestCase
{
    private ClockInterface $clock;
    private EventDispatcher $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clock = new FakeClock();
        $this->eventDispatcher = new LaravelEventDispatcher();
    }

    public function testItRecordBalanceTransactionOnBillPayment()
    {
        $bill = EloquentBill::factory()->create();

        $event = new BillPaid(
            $bill->reference,
            $amount = round($bill->amount * 1.21),
            $this->clock->now()
        );

        $this->eventDispatcher->dispatch($event);

        $this->assertDatabaseHas(EloquentBalanceTransaction::class, [
            'type' => BalanceType::BILL->value,
            'reference' => $bill->reference,
            'amount' => $amount,
            'occurred_on' => $this->clock->now(),
        ]);
    }

    public function testItRecordBalanceTransactionOnExpensePayment()
    {
        $expense = EloquentExpense::factory()->create();

        $event = new ExpensePaid(
            $expense->reference,
            $amount = round($expense->amount * 1.21),
            $this->clock->now()
        );

        $this->eventDispatcher->dispatch($event);

        $this->assertDatabaseHas(EloquentBalanceTransaction::class, [
            'type' => BalanceType::EXPENSE->value,
            'reference' => $expense->reference,
            'amount' => $amount,
            'occurred_on' => $this->clock->now(),
        ]);
    }
}
