<?php

namespace Module\Expense\Domain\Events;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\DomainEvent;

class ExpensePaid implements DomainEvent
{
    public const NAME = 'ExpensePaid';

    public function __construct(
        private readonly string $expenseReference,
        private readonly int $amountPaid,
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
            'reference' => $this->expenseReference,
            'amountPaid' => $this->amountPaid,
            'paymentDateTime' => $this->paymentDatetime->toIso8601String(),
        ];
    }
}
