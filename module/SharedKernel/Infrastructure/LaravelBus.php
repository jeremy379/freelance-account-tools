<?php

namespace Module\SharedKernel\Infrastructure;

use Illuminate\Support\Facades\Bus as LaravelFacadeBus;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\Command;
use Module\SharedKernel\Domain\Query;

class LaravelBus implements Bus
{
    public function dispatch(Command|Query $action): mixed
    {
        return LaravelFacadeBus::dispatch($action);
    }
}
