<?php

namespace Module\Reporting\Domain\Service;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Objects\Amount;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\BalanceOverTime;
use Module\Reporting\Domain\ReportingRepository;

class ComputeBalanceOverTime
{
    public function __construct(private ReportingRepository $repository)
    {
    }

    public function on(CarbonImmutable $datetime): BalanceOnDatetime
    {
        $balanceBetween = $this->between($datetime, $datetime);

        return $balanceBetween->last() ?? new BalanceOnDatetime(Amount::fromStoredInt(0), $datetime);
    }

    public function between(CarbonImmutable $from, CarbonImmutable $to): BalanceOverTime
    {
        $balancesEntries = $this->repository->balanceBetween($from, $to);

        $balanceOverTime = BalanceOverTime::new();
        $cumulatedEntries = [];
        $previousAmount = 0;

        foreach($balancesEntries as $balanceEntry) {
            $timestamp = CarbonImmutable::parse($balanceEntry['occurred_on'])->timestamp;

            $cumulatedEntries[$timestamp] = $previousAmount + $balanceEntry['amount'];

            $previousAmount += $balanceEntry['amount'];
        }

        foreach($cumulatedEntries as $timestamp => $amount) {
            $balanceOverTime = $balanceOverTime->with(
                new BalanceOnDatetime(
                    Amount::fromStoredInt($amount),
                    CarbonImmutable::createFromTimestamp($timestamp)
                )
            );
        }

        return $balanceOverTime;
    }
}
