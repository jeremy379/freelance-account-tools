<?php

namespace Module\Expense\Domain\Objects;

class YearlyExpense
{
    public function __construct(
        public readonly float $totalExpense,
        public readonly float $totalDeductibleExpense,
        public readonly int $expenseCount,
        public readonly float $vatToRecover,
        public readonly float $taxProvisioned,
        public readonly float $socialContributionAlreadyPaid,
        public readonly int $year,
    ) {
    }

    public function toArray(): array
    {
        return [
            'totalExpense' => $this->totalExpense,
            'totalDeductibleExpense' => $this->totalDeductibleExpense,
            'expenseCount' => $this->expenseCount,
            'vatToRecover' => $this->vatToRecover,
            'taxProvisioned' => $this->taxProvisioned,
            'socialContributionAlreadyPaid' => $this->socialContributionAlreadyPaid,
            'year' => $this->year,
        ];
    }
}
