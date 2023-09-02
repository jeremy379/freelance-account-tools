<?php

namespace Module\Billing\Domain\Objects;

use Carbon\CarbonImmutable;

class BillPayment
{
    private function __construct(public readonly CarbonImmutable $on, public readonly Amount $amount)
    {
    }

    public static function with(CarbonImmutable $on, Amount $amount): BillPayment
    {
        return new self($on, $amount);
    }
}
