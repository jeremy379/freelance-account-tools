<?php

namespace Module\Reporting;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Reporting\Application\GetBalanceOnDatetimeQuery;
use Module\Reporting\Application\GetBalanceOnDatetimeQueryHandler;
use Module\Reporting\Application\GetBalanceOverPeriodQuery;
use Module\Reporting\Application\GetBalanceOverPeriodQueryHandler;
use Module\Reporting\Domain\ReportingRepository;
use Module\Reporting\Infrastructure\Repository\ReportingRepositoryDatabase;

class ReportingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ReportingRepository::class, ReportingRepositoryDatabase::class);
    }

    public function boot()
    {
        Bus::map([
            GetBalanceOnDatetimeQuery::class => GetBalanceOnDatetimeQueryHandler::class,
            GetBalanceOverPeriodQuery::class => GetBalanceOverPeriodQueryHandler::class,
        ]);
    }
}
