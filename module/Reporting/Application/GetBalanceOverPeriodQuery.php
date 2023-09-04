<?php

namespace Module\Reporting\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Query;

class GetBalanceOverPeriodQuery implements Query
{
    public function __construct(public readonly CarbonImmutable $from, public readonly CarbonImmutable $to)
    {
    }
}
