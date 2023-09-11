<?php

namespace Module\Billing\Domain\Objects;

class YearlyBill
{
    public function __construct(
        public readonly int $year,
        public readonly float $total,
        public readonly float $totalVatCollected,
        public readonly int $billCount,
    ) {
    }

    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'total' => $this->total,
            'totalVatCollected' => $this->totalVatCollected,
            'billCount' => $this->billCount,
        ];
    }
}
