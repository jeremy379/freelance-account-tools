<?php

namespace Module\Forecast;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Forecast\Application\CreateExpenseForecastCommand;
use Module\Forecast\Application\CreateIncomeForecastCommand;
use Module\Forecast\Application\CreateForecastCommandHandler;
use Module\Forecast\Domain\ForecastRepository;
use Module\Forecast\Infrastructure\Repository\ForecastRepositoryDatabase;

class ForecastServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ForecastRepository::class, ForecastRepositoryDatabase::class);
    }

    public function boot()
    {
        Bus::map([
            CreateIncomeForecastCommand::class => CreateForecastCommandHandler::class,
            CreateExpenseForecastCommand::class => CreateForecastCommandHandler::class,
        ]);
    }
}
