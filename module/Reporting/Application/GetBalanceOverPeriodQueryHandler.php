<?php

namespace Module\Reporting\Application;

use Carbon\CarbonImmutable;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\BalanceOverTime;
use Module\Reporting\Domain\Service\ComputeBalanceOverTime;
use Module\SharedKernel\Domain\Query;

class GetBalanceOverPeriodQueryHandler implements Query
{
    public function __construct(private readonly ComputeBalanceOverTime $balanceOverTime)
    {
    }

    public function handle(GetBalanceOverPeriodQuery $query): BalanceOverTime
    {
        return $this->balanceOverTime->between($query->from, $query->to);
    }
}
