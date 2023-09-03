<?php

namespace Module\Reporting\Application;

use Module\Balance\Domain\Objects\Amount;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\ReportingRepository;

class GetBalanceOnDatetimeQueryHandler
{
    public function __construct(private ReportingRepository $repository)
    {
    }

    public function handle(GetBalanceOnDatetimeQuery $query): BalanceOnDatetime
    {
        $balanceBetween = $this->repository->balanceBetween($query->datetime, $query->datetime);

        return $balanceBetween->first() ?? new BalanceOnDatetime(Amount::fromStoredInt(0), $query->datetime);
    }
}
