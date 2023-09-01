<?php

namespace Tests\Feature;

use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Infrastructure\Repository\ExpenseRepositoryDatabase;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\EventDispatcher;
use Module\SharedKernel\Infrastructure\LaravelBus;
use Tests\FakeEventDispatcher;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    private Bus $bus;
    private EventDispatcher $eventDispatcher;
    private ExpenseRepository $expenseRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bus = new LaravelBus();
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->expenseRepository = new ExpenseRepositoryDatabase();
    }

    public function testItRecordsExpense()
    {
        $command = new CreateExpenseCommand();

        $this->bus->dispatch($command);

        //Check expense recorded in DB

        $this->eventDispatcher->assertEmitted(new ExpensePaid());
    }
}
