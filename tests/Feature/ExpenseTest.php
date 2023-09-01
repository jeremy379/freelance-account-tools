<?php

namespace Tests\Feature;

use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\Expense\Infrastructure\Repository\ExpenseRepositoryDatabase;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\EventDispatcher;
use Module\SharedKernel\Infrastructure\LaravelBus;
use Psr\Clock\ClockInterface;
use Tests\FakeClock;
use Tests\FakeEventDispatcher;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    private Bus $bus;
    private EventDispatcher $eventDispatcher;
    private ExpenseRepository $expenseRepository;
    private ClockInterface $clock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bus = new LaravelBus();
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->expenseRepository = new ExpenseRepositoryDatabase();
        $this->clock = new FakeClock();
    }

    public function testItRecordsExpense()
    {
        $command = new CreateExpenseCommand(
            $reference = 'expense-001',
        );

        $this->bus->dispatch($command);

        $expenseInDb = EloquentExpense::where('reference', $reference)->first();

        $this->assertNotNull($expenseInDb);

        $this->eventDispatcher->assertEmitted(new ExpensePaid($reference, '1', $this->clock->now()));
    }
}
