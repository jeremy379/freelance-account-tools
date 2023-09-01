<?php

namespace Module\Balance\Domain;

use Carbon\CarbonImmutable;

class Balance
{
    private function __construct(
        public readonly int $amount,
        public readonly string $type,
        public readonly string $reference,
        public readonly CarbonImmutable $datetime,
    )
    {
    }
}
