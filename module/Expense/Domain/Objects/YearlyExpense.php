<?php

namespace Module\Expense\Domain\Objects;

class YearlyExpense
{
    public function __construct(
        public readonly float $totalExpense,
        public readonly float $totalDeductibleExpense,
        public readonly int $expenseCount,
        public readonly float $vatToRecover,
        public readonly int $year,
    )
    {
    }
}
