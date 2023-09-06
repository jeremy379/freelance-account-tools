<?php

namespace Module\Forecast\Application;

use Carbon\CarbonImmutable;
use Module\Forecast\Domain\ForecastRepository;
use Module\SharedKernel\Domain\Command;

class CreateForecastCommandHandler
{
    public function __construct(private ForecastRepository $repository)
    {
    }

    public function handle(CreateForecastCommand $command): void
    {
    }
}
