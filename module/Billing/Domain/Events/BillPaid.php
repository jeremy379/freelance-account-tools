<?php

namespace Module\Billing\Domain\Events;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\DomainEvent;

class BillPaid implements DomainEvent
{
    public const NAME = 'BillPaid';

    public function __construct(
        public readonly string $billReference,
        public readonly int $amountPaid,
        private readonly CarbonImmutable $paymentDatetime,
    ) {
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function payload(): array
    {
        return [
            'reference' => $this->billReference,
            'amountPaid' => $this->amountPaid,
            'paymentDateTime' => $this->paymentDatetime->toIso8601String(),
        ];
    }
}
