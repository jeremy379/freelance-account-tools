<?php

namespace Module\Expense\Application;

use DateTimeImmutable;
use Module\SharedKernel\Domain\Command;

class CreateExpenseCommand implements Command
{
    public function __construct(
        public readonly string             $reference,
        public readonly string             $category,
        public readonly string             $provider,
        public readonly float              $amount,
        public readonly int|string         $taxRate,
        public readonly string             $countryCode,
        public readonly ?DateTimeImmutable $paymentDate = null
    )
    {
    }
}
