<?php

namespace Module\SharedKernel\Domain;

interface DomainEntityWithEvents
{
    public function chainEvent(DomainEvent $domainEvent): void;

    /** @return array<DomainEvent> */
    public function popEvents(): array;
}
