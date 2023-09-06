<?php

namespace Module\Forecast\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;

class ForecastRepositoryDatabase implements ForecastRepository
{
    public function save(Forecast $forecast): void
    {
        // TODO: Implement save() method.
    }

    public function expenseForecastedForYear(CarbonImmutable $dateTime): array
    {
        // TODO: Implement expenseForecastedForYear() method.
    }

    public function incomeForecastedForYear(CarbonImmutable $dateTime): array
    {
        // TODO: Implement incomeForecastedForYear() method.
    }
}
