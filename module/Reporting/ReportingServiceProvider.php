<?php

namespace Module\Reporting;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class ReportingServiceProvider extends ServiceProvider
{
    public function register()
    {
        //$this->app->bind(interface, concrete);
    }

    public function boot()
    {
        Bus::map([]);
    }
}
