<?php

namespace Module\Forecast\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Command;

class CreateForecastCommand implements Command
{
    public function __construct(
        public readonly float $amount,
        public readonly int $vatRate,
        public readonly CarbonImmutable $forecastedOn,
        public readonly ?string $category = null,
    )
    {
    }
}
