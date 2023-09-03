<?php

namespace Module\Balance;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Balance\Domain\BalanceRepository;
use Module\Balance\Infrastructure\Repository\BalanceRepositoryDatabase;

class BalanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BalanceRepository::class, BalanceRepositoryDatabase::class);
    }

    public function boot()
    {
        Bus::map([]);
    }
}
