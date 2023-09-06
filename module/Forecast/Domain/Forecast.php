<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\Objects\ForecastAmount;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\VatRate;

class Forecast
{
    private function __construct(
        ForecastAmount  $amount,
        Category        $category,
        VatRate         $taxRate,
        CarbonImmutable $forecastedOn
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
