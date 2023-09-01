<?php

namespace Module\Balance;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BalanceServiceProvider extends ServiceProvider
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
