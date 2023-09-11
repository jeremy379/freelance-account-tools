<?php

namespace Module\Balance\Domain;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Events\BalanceEntryRecorded;
use Module\Balance\Domain\Objects\Amount;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Domain\Objects\Reference;
use Module\SharedKernel\Domain\DomainEntityWithEvents;
use Module\SharedKernel\Domain\DomainEvent;

class Balance implements DomainEntityWithEvents
{
    private array $events = [];

    private function __construct(
        public readonly Amount $amount,
        public readonly BalanceType $type,
        public readonly Reference $reference,
        public readonly CarbonImmutable $datetime,
    ) {
    }

    public static function newEntry(
        Amount $amount,
        BalanceType $type,
        Reference $reference,
        CarbonImmutable $datetime,
    ): Balance {
        if ($type === BalanceType::EXPENSE) {
            $amount = Amount::fromStoredInt($amount->toInt() * -1);
        }
        $entry = new self($amount, $type, $reference, $datetime);

        $entry->chainEvent(new BalanceEntryRecorded($amount->toInt(), $type->value, $datetime));

        return $entry;
    }

    public static function restore(
        Amount $amount,
        BalanceType $type,
        Reference $reference,
        CarbonImmutable $datetime,
    ): Balance {
        return new self(
            $amount,
            $type,
            $reference,
            $datetime,
        );
    }

    public function chainEvent(DomainEvent $domainEvent): void
    {
        $this->events[] = $domainEvent;
    }

    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
