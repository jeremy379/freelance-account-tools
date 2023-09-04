<?php

namespace Module\Balance\Domain\Events;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\DomainEvent;

class BalanceEntryRecorded implements DomainEvent
{
    public const NAME = 'BalanceEntryRecorded';

    public function __construct(private readonly int $amount, private readonly string $type, private readonly CarbonImmutable $datetime)
    {
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function payload(): array
    {
        return [
            'amount' => $this->amount,
            'type' => $this->type,
            'datetime' => $this->datetime->toIso8601String(),
        ];
    }
}
