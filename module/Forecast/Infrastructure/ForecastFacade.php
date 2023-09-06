<?php

namespace Module\Forecast\Infrastructure;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;

class ForecastFacade
{
    public function __construct(private ForecastRepository $forecastRepository)
    {
    }

    public function getExpensesForecasted(int $year): array
    {
        return array_map(
            fn(Forecast $forecast) => $forecast->toArray(),
            $this->forecastRepository->expenseForecastedForYear(CarbonImmutable::now()->year($year))
        );
    }

    public function getIncomeForecasted(int $year): array
    {
        return array_map(
            fn(Forecast $forecast) => $forecast->toArray(),
            $this->forecastRepository->incomeForecastedForYear(CarbonImmutable::now()->year($year))
        );
    }
}
