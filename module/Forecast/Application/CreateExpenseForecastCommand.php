<?php

namespace Module\Forecast\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Command;

class CreateExpenseForecastCommand implements Command
{
    public function __construct(
        public readonly float $amount,
        public readonly string $vatRate,
        public readonly CarbonImmutable $forecastedOn,
        public readonly string $category,
        public readonly string $countryCode,
    )
    {
    }
}
