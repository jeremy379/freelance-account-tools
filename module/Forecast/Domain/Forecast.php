<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\Objects\ForecastAmount;
use Module\Forecast\Domain\Objects\ForecastType;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\VatRate;

class Forecast
{
    private function __construct(
        public readonly ForecastType $forecastType,
        public readonly ForecastAmount $amount,
        public readonly Category $category,
        public readonly VatRate $vatRate,
        public readonly CarbonImmutable $forecastedOn
    )
    {
    }

    public static function income(): Forecast
    {

    }

    public static function expense(): Forecast
    {

    }
}
