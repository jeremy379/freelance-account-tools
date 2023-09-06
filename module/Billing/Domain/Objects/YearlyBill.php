<?php

namespace Module\Billing\Domain\Objects;

class YearlyBill
{
    public function __construct(
        public readonly int $year,
        public readonly float $total,
        public readonly float $totalVatCollected,
        public readonly int $billCount,
    )
    {
    }
}
