<?php

namespace Module\Reporting\Application;

use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\Service\ComputeBalanceOverTime;

class GetBalanceOnDatetimeQueryHandler
{
    public function __construct(private ComputeBalanceOverTime $balanceOverTime)
    {
    }

    public function handle(GetBalanceOnDatetimeQuery $query): BalanceOnDatetime
    {
        return $this->balanceOverTime->on($query->datetime);
    }
}
