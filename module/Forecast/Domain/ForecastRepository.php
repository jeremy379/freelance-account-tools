<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;

interface ForecastRepository
{
    public function save(Forecast $forecast): void;

    public function expenseForecastedForYear(CarbonImmutable $dateTime): array;

    public function incomeForecastedForYear(CarbonImmutable $dateTime): array;
}
