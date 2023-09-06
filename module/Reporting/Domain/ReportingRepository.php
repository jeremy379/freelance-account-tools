<?php

namespace Module\Reporting\Domain;

use Carbon\CarbonImmutable;

interface ReportingRepository
{
    public function balanceBetween(CarbonImmutable $from, CarbonImmutable $to): array;

    public function retrieveYearlyOverview(int $year): array;

    public function retrieveYearlyForecastedOverview(int $year): array;
}
