<?php

namespace Module\Client;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
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
