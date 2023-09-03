<?php

namespace Module\Reporting\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Query;

class GetBalanceOnDatetimeQuery implements Query
{
    public function __construct(public readonly CarbonImmutable $datetime)
    {
    }
}
