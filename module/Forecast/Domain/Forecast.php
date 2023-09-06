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
        public readonly ?Category $category,
        public readonly VatRate $vatRate,
        public readonly CarbonImmutable $forecastedOn
    )
    {
    }

    public static function restore(
        ForecastType $forecastType,
        ForecastAmount $amount,
        ?Category $category,
        VatRate $vatRate,
        CarbonImmutable $forecastedOn
    ): Forecast
    {
        return new self(
            $forecastType,
            $amount,
            $category,
            $vatRate,
            $forecastedOn
        );
    }

    public static function income(
        ForecastAmount $amount,
        VatRate $vatRate,
        CarbonImmutable $forecastedOn
    ): Forecast
    {
        return new self(
            ForecastType::INCOME,
            $amount,
            null,
            $vatRate,
            $forecastedOn
        );
    }

    public static function expense(
        ForecastAmount $amount,
        Category $category,
        VatRate $vatRate,
        CarbonImmutable $forecastedOn
    ): Forecast
    {
        return new self(
            ForecastType::EXPENSE,
            $amount,
            $category,
            $vatRate,
            $forecastedOn
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->forecastType->value,
            'int_amount' => $this->amount->toInt(),
            'category' => $this->category?->value,
            'vat_rate' => $this->vatRate->taxRatePercentage,
            'forecasted_on' => $this->forecastedOn->toIso8601String(),
        ];
    }
}
