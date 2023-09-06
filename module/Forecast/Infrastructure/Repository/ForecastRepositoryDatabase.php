<?php

namespace Module\Forecast\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;
use Module\Forecast\Domain\Objects\ForecastType;
use Module\Forecast\Infrastructure\Eloquent\EloquentForecast;

class ForecastRepositoryDatabase implements ForecastRepository
{
    public function __construct(private ForecastFactory $factory)
    {
    }

    public function save(Forecast $forecast): void
    {
        EloquentForecast::create([
            'type' => $forecast->forecastType->value,
            'category' => $forecast->category?->value,
            'amount' => $forecast->amount->toInt(),
            'vat_rate' => $forecast->vatRate->taxRatePercentage,
            'forecasted_on' => $forecast->forecastedOn,
        ]);
    }

    public function expenseForecastedForYear(CarbonImmutable $dateTime): array
    {
        return EloquentForecast::query()
            ->where('type', ForecastType::EXPENSE->value)
            ->whereYear('forecasted_on', $dateTime->year)
            ->get()
            ->transform(fn(EloquentForecast $forecast) => $this->factory->toForecast($forecast))
            ->toArray();
    }

    public function incomeForecastedForYear(CarbonImmutable $dateTime): array
    {
        return EloquentForecast::query()
            ->where('type', ForecastType::INCOME->value)
            ->whereYear('forecasted_on', $dateTime->year)
            ->get()
            ->transform(fn(EloquentForecast $forecast) => $this->factory->toForecast($forecast))
            ->toArray();
    }
}
