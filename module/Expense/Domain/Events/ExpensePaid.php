<?php

namespace Module\Expense\Domain\Events;

use Module\SharedKernel\Domain\DomainEvent;

class ExpensePaid implements DomainEvent
{
    public function __construct(private readonly string $expenseReference, private readonly int $amountPaid)
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
            'amountPaid' => $this->amountPaid
        ];
    }
}
