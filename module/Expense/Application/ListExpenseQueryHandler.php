<?php

namespace Module\Expense\Application;

use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;

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
