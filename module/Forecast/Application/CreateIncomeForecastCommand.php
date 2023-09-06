<?php

namespace Module\Forecast\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Command;

class CreateIncomeForecastCommand implements Command
{
    public function __construct(
        public readonly float $amount,
        public readonly int $vatRate,
        public readonly CarbonImmutable $forecastedOn,
    )
    {
    }
}
