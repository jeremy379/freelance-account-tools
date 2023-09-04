<?php

namespace Module\Reporting\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Reporting\Domain\ReportingRepository;

class ReportingRepositoryDatabase implements ReportingRepository
{
    public function balanceBetween(CarbonImmutable $from, CarbonImmutable $to): array
    {
        return EloquentBalanceTransaction::query()
            ->where('occurred_on', '<=', $to)
            ->orderBy('occurred_on')
            ->get()
            ->toArray();
    }
}
