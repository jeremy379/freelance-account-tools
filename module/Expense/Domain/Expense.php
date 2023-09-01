<?php

namespace Module\Expense\Domain;

use Module\SharedKernel\Domain\DomainEntityWithEvents;
use Module\SharedKernel\Domain\DomainEvent;

class Expense implements DomainEntityWithEvents
{
    private array $events = [];

    private function __construct(
        public readonly string $reference,
        public readonly string $category,
        public readonly string $provider,
        public readonly int $amount,
        public readonly int $taxRate,
        public readonly string $countryCode,
    )
    {
    }

    public static function record(): Expense
    {
        return new self();
    }

    public function chainEvent(DomainEvent $domainEvent): void
    {
        $this->events[] = $domainEvent;
    }

    public function popEvents(): array
    {
        return $this->events;
    }
}
