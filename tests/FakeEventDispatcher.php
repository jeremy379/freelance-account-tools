<?php

namespace Tests;

use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\EventDispatcher;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;

class FakeEventDispatcher implements EventDispatcher
{
    /** @var array<DomainEvent>  */
    public array $emitted = [];

    public function dispatch(DomainEvent $event): void
    {
        $this->emitted[] = $event;
    }

    public function assertEmitted(DomainEvent $event): void
    {
        foreach($this->emitted as $emittedEvents) {
            if($emittedEvents->name() === $event->name() && $emittedEvents->payload() === $event->payload()) {
                return;
            }
        }

        throw new ExpectationFailedException(
            'Failing asserting that event ' . $event->name() . ' was emitted with payload ' . json_encode($event->payload())
        );
    }
}
