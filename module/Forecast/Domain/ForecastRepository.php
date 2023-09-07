<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;

interface ForecastRepository
{
    public function save(Forecast $forecast): void;

    /**
     * @return array<Forecast>
     */
    public function expenseForecastedForYear(CarbonImmutable $dateTime, bool $onlyFutureMonth = false): array;

    /**
     * @return array<Forecast>
     */
    public function incomeForecastedForYear(CarbonImmutable $dateTime, bool $onlyFutureMonth = false): array;
}
