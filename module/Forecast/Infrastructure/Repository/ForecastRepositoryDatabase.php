<?php

namespace Module\Forecast\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;
use Module\Forecast\Infrastructure\Eloquent\EloquentForecast;

class ForecastRepositoryDatabase implements ForecastRepository
{
    public function save(Forecast $forecast): void
    {
        EloquentForecast::create([
            'type' => $forecast->forecastType->value,
            'category' => $forecast->category->value,
            'amount' => $forecast->amount->toInt(),
            'vat_rate' => $forecast->vatRate->taxRatePercentage,
            'forecasted_on' => $forecast->forecastedOn,
        ]);
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
