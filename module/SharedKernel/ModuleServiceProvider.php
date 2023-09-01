<?php

namespace Module\SharedKernel;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\SharedKernel\Domain\EventDispatcher;
use Module\SharedKernel\Infrastructure\LaravelBus;
use Module\SharedKernel\Infrastructure\LaravelEventDispatcher;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EventDispatcher::class, LaravelEventDispatcher::class);
        $this->app->bind(Domain\Bus::class, LaravelBus::class);
    }

    public function boot()
    {
        Bus::map([]);
    }
}
