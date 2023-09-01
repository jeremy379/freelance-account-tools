<?php

namespace Module\Balance\Domain;

use Carbon\CarbonImmutable;

class Balance
{
    private function __construct(
        public readonly int $amount,
        public readonly CarbonImmutable $datetime,
    )
    {
    }
}
