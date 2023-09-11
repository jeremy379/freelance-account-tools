<?php

namespace Tests;

use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\EventDispatcher;
use PHPUnit\Framework\ExpectationFailedException;

class FakeEventDispatcher implements EventDispatcher
{
    /** @var array<DomainEvent> */
    public array $emitted = [];

    public function dispatch(DomainEvent ...$events): void
    {
        $this->emitted = array_merge($this->emitted, $events);
    }

    public function assertEmitted(DomainEvent $event): void
    {
        foreach ($this->emitted as $emittedEvents) {
            if ($emittedEvents->name() === $event->name() && $emittedEvents->payload() === $event->payload()) {
                return;
            }
        }

        throw new ExpectationFailedException(
            'Failing asserting that event '.$event->name().' was emitted with payload '.json_encode($event->payload())
        );
    }
}
