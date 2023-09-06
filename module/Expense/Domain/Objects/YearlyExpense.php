<?php

namespace Module\Expense\Domain\Objects;

class YearlyExpense
{
    public function __construct(
        public readonly float $totalExpense,
        public readonly float $totalDeductibleExpense,
        public readonly int $expenseCount,
        public readonly int $year,
    )
    {
    }
}
