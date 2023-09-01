<?php

namespace Module\Expense\Domain\Events;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\DomainEvent;

class ExpensePaid implements DomainEvent
{
    public function __construct(
        private readonly string $expenseReference,
        private readonly int $amountPaid,
        private readonly \DateTimeImmutable $paymentDatetime,
    )
    {
    }


    public function name(): string
    {
        return 'ExpensePaid';
    }

    public function payload(): array
    {
        return [
            'reference' => $this->expenseReference,
            'amountPaid' => $this->amountPaid,
            'paymentDateTime' => $this->paymentDatetime->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
