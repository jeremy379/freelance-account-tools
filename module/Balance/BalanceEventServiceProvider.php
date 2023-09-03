<?php

namespace Module\Balance;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Balance\Infrastructure\Listener\BalanceEventSubscriber;

class BalanceEventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        BalanceEventSubscriber::class,
    ];
}
