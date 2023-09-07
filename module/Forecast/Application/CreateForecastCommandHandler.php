<?php

namespace Module\Forecast\Application;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Forecast\Domain\Forecast;
use Module\Forecast\Domain\ForecastRepository;
use Module\Forecast\Domain\Objects\ForecastAmount;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\Command;
use Module\SharedKernel\Domain\VatRate;

class CreateForecastCommandHandler
{
    public function __construct(private ForecastRepository $repository)
    {
    }

    public function handle(CreateIncomeForecastCommand|CreateExpenseForecastCommand $command): void
    {
        if($command instanceof CreateIncomeForecastCommand) {
            $forecast = Forecast::income(
                ForecastAmount::fromFloat($command->amount),
                VatRate::fromStoredValue($command->vatRate),
                $command->forecastedOn
            );
        } else {
            $forecast = Forecast::expense(
                ForecastAmount::fromFloat($command->amount),
                Category::from($command->category),
                VatRate::fromStoredValue($command->vatRate),
                $command->forecastedOn,
                CountryCode::from($command->countryCode)
            );
        }

        $this->repository->save($forecast);
    }
}
