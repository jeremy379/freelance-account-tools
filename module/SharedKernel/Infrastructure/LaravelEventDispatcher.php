<?php

namespace Module\SharedKernel\Infrastructure;

use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\EventDispatcher;

class LaravelEventDispatcher implements EventDispatcher
{
    public function dispatch(DomainEvent $event): void
    {
        event($event->name(), $event->payload());
    }
}
