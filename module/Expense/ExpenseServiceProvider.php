<?php

namespace Module\Expense;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class ExpenseServiceProvider extends ServiceProvider
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
