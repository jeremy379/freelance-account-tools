<?php

namespace Module\SharedKernel\Infrastructure;

use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\EventDispatcher;

class LaravelEventDispatcher implements EventDispatcher
{
    public function dispatch(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            event($event->name(), $event->payload());
        }
    }
}
