<?php

namespace Module\Forecast\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\Objects\ForecastAmount;
use Module\Forecast\Domain\Objects\ForecastType;
use Module\Forecast\Infrastructure\Eloquent\EloquentForecast;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\VatRate;

class ForecastFactory
{
    public function toForecast(EloquentForecast $forecast): Forecast
    {
        return Forecast::restore(
            ForecastType::from($forecast->type),
            ForecastAmount::fromStoredInt($forecast->amount),
            $forecast->category ? Category::from($forecast->category) : null,
            VatRate::fromStoredValue($forecast->vat_rate),
            CarbonImmutable::parse($forecast->forecasted_on),
            $forecast->country_code ? CountryCode::from($forecast->country_code) : null,
        );
    }
}
