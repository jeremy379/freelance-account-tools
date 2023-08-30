<?php

namespace Module\Billing;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
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
