<?php

namespace Module\Expense\Domain;

use Module\SharedKernel\Domain\DomainEntityWithEvents;
use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\SavingMode;

class Expense implements DomainEntityWithEvents
{
    private array $events = [];
    private SavingMode $savingMode;

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
        $expense =  new self();
        $expense->savingMode = SavingMode::CREATE;

        return $expense;
    }

    public function chainEvent(DomainEvent $domainEvent): void
    {
        $this->events[] = $domainEvent;
    }

    public function popEvents(): array
    {
        return $this->events;
    }

    public function savingMode(): SavingMode
    {
        return $this->savingMode;
    }
}
