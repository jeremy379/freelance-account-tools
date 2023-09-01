<?php

namespace Feature;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalance;
use Module\Expense\Application\ListExpensePaidBetweenQuery;
use Module\Expense\Application\ListExpenseQueryHandler;
use Module\Expense\Domain\Expense;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\Expense\Infrastructure\Repository\ExpenseDomainFactory;
use Module\SharedKernel\Domain\ClockInterface;
use Tests\FakeClock;
use Tests\TestCase;

class ListExpensePaidBetweenTest extends TestCase
{
    private ClockInterface $clock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clock = new FakeClock();
    }

    public function testItListExpensesInTimeframe()
    {
        $expense1 = $this->givenAnExpensePaidOn($this->clock->now());
        $expense2 = $this->givenAnExpensePaidOn($this->clock->now()->addDay());
        $this->givenAnExpensePaidOn($this->clock->now()->addMonth());

        $query = new ListExpensePaidBetweenQuery(
            $this->clock->now(),
            $this->clock->now()->addWeek()
        );

        $queryHandler = new ListExpenseQueryHandler();

        $expenses = $queryHandler->handle($query);

        $this->assertNotEmpty($expenses);
        $this->assertCount(2, $expenses);

        $expenseObjectFactory = new ExpenseDomainFactory();

        $this->assertContainsEquals($expenseObjectFactory($expense1), $expenses);
        $this->assertContainsEquals($expenseObjectFactory($expense2), $expenses);
    }

    private function givenAnExpensePaidOn(CarbonImmutable $on): Expense
    {
        $expense = EloquentExpense::factory()->create();

        EloquentBalance::factory()->create([
            'type' => BalanceType::EXPENSE,
            'reference' => $expense->reference
        ]);

        return $expense;
    }
}
