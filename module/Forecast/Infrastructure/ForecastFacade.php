<?php

namespace Module\Forecast\Infrastructure;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Forecast\Domain\ComputeYearlyForecastedExpense;
use Module\Forecast\Domain\ComputeYearlyForecastedIncome;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;

class ForecastFacade
{
    public function __construct(
        private readonly ForecastRepository $forecastRepository,
    ) {
    }

    public function getExpensesForecasted(int $year, bool $onlyFutureMonth = false): array
    {
        $computer = new ComputeYearlyForecastedExpense(
            $this->forecastRepository,
            DeductibilityConfiguration::loadConfiguration(config('calculator.deductibility'))
        );

        return $computer->compute($year, $onlyFutureMonth)->toArray();
    }

    public function getIncomeForecasted(int $year, bool $onlyFutureMonth = false): array
    {
        $computer = new ComputeYearlyForecastedIncome($this->forecastRepository);

        return $computer->compute($year, $onlyFutureMonth)->toArray();
    }
}
