<?php

namespace Tests\Feature;

use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Application\CreateExpenseCommandHandler;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\Expense\Domain\Exception\CannotCreateExpense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\Expense\Infrastructure\Repository\ExpenseRepositoryDatabase;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Domain\EventDispatcher;
use Tests\FakeClock;
use Tests\FakeEventDispatcher;
use Tests\TestCase;

class CreateExpenseTest extends TestCase
{
    private EventDispatcher $eventDispatcher;
    private ExpenseRepository $expenseRepository;
    private ClockInterface $clock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventDispatcher = new FakeEventDispatcher();
        $this->expenseRepository = new ExpenseRepositoryDatabase();
        $this->clock = new FakeClock();
    }

    public function testItRecordsExpense()
    {
        $command = new CreateExpenseCommand(
            $reference = 'expense-001',
            'car',
            'company-1',
            $amount = 500.54,
            $taxRate = 21,
            'BE'
        );

        $commandHandler = new CreateExpenseCommandHandler(
            $this->expenseRepository,
            $this->eventDispatcher
        );

        $commandHandler->handle($command);

        $expenseInDb = EloquentExpense::where('reference', $reference)->first();

        $this->assertNotNull($expenseInDb);
        $this->assertDatabaseHas(EloquentExpense::class, [
            'reference' => $reference,
            'category' => 'CAR',
            'provider' => 'company-1',
            'amount' => '50054',
            'tax_rate' => 21,
            'country_code' => 'BE'
        ]);
    }

    public function testItRecordsAndMarkExpensePaid()
    {
        $command = new CreateExpenseCommand(
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

        $expenseInDb = EloquentExpense::where('reference', $reference)->first();

        $this->assertNotNull($expenseInDb);

        $this->eventDispatcher->assertEmitted(new ExpensePaid($reference, ($amount + ($amount * $taxRate/100)) * 100, $this->clock->now()));
    }

    public function testItFailsWhenExpenseReferenceAlreadyExists()
    {
        $command = new CreateExpenseCommand(
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
