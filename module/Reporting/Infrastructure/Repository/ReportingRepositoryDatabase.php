<?php

namespace Module\Reporting\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Reporting\Domain\BalanceOverTime;
use Module\Reporting\Domain\ReportingRepository;

class ReportingRepositoryDatabase implements ReportingRepository
{
    public function balanceBetween(CarbonImmutable $from, CarbonImmutable $to): BalanceOverTime
    {
        $balances = EloquentBalanceTransaction::query()

            ->get();

        $balanceOverTime = BalanceOverTime::new();


        return $balanceOverTime;
    }
}
