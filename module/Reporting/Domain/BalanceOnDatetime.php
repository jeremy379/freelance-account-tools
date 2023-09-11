<?php

namespace Module\Reporting\Domain;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Objects\Amount;

class BalanceOnDatetime
{
    public function __construct(
        public readonly Amount $amount,
        public readonly CarbonImmutable $datetime
    ) {
    }
}
