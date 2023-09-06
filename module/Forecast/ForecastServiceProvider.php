<?php

namespace Module\Forecast;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Forecast\Application\CreateForecastCommand;
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
            CreateForecastCommand::class => CreateForecastCommandHandler::class,
        ]);
    }
}
