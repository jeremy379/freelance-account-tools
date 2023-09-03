<?php

namespace Module\Reporting\Domain;

use Carbon\CarbonImmutable;

interface ReportingRepository
{
    public function balanceBetween(CarbonImmutable $from, CarbonImmutable $to): BalanceOverTime;
}
