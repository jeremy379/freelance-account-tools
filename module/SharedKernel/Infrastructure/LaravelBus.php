<?php

namespace Module\SharedKernel\Infrastructure;

use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\Command;
use Module\SharedKernel\Domain\Query;

class LaravelBus implements Bus
{
    public function dispatch(Command|Query $action): mixed
    {
        return \Illuminate\Support\Facades\Bus::dispatch($action);
    }
}
