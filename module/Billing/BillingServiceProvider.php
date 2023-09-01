<?php

namespace Module\Billing;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Infrastructure\Repository\BillRepositoryDatabase;

class BillingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BillRepository::class, BillRepositoryDatabase::class);
    }

    public function boot()
    {
        Bus::map([]);
    }
}
