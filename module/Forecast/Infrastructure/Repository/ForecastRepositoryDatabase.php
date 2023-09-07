<?php

namespace Module\Forecast\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;
use Module\Forecast\Domain\Objects\ForecastType;
use Module\Forecast\Infrastructure\Eloquent\EloquentForecast;
use Module\SharedKernel\Domain\ClockInterface;

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
            'country_code' => $forecast->countryCodeWhereExpenseIsMade?->value,
        ]);
    }

    public function expenseForecastedForYear(CarbonImmutable $dateTime, bool $onlyFutureMonth = false): array
    {
        return EloquentForecast::query()
            ->where('type', ForecastType::EXPENSE->value)
            ->where(function(Builder $query) use ($dateTime, $onlyFutureMonth) {
                $query->whereYear('forecasted_on', $dateTime->year);

                if($onlyFutureMonth) {
                    $query->whereMonth('forecasted_on', '>', $dateTime->month);
                }
            })
            ->get()
            ->transform(fn(EloquentForecast $forecast) => $this->factory->toForecast($forecast))
            ->toArray();
    }

    public function incomeForecastedForYear(CarbonImmutable $dateTime, bool $onlyFutureMonth = false): array
    {
        return EloquentForecast::query()
            ->where('type', ForecastType::INCOME->value)
            ->where(function(Builder $query) use ($dateTime, $onlyFutureMonth) {
                $query->whereYear('forecasted_on', $dateTime->year);

                if($onlyFutureMonth) {
                    $query->whereMonth('forecasted_on', '>', $dateTime->month);
                }
            })
            ->get()
            ->transform(fn(EloquentForecast $forecast) => $this->factory->toForecast($forecast))
            ->toArray();
    }
}
