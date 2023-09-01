<?php

namespace Module\Expense\Application;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\BalanceRepository;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Domain\ReadModel\BalanceTransactions;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\SharedKernel\Domain\Query;

class ListExpenseQueryHandler
{
    public function __construct(private ExpenseRepository $expenseRepository)
    {
    }

    /**
     * @return array<Expense>
     */
    public function handle(ListExpensePaidBetweenQuery $query): array
    {
        return $this->expenseRepository->fetchBetween($query->from, $query->to);
    }
}
