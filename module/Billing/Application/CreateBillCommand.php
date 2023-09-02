<?php

namespace Module\Billing\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Command;

class CreateBillCommand implements Command
{
    public function __construct(
        public readonly string $reference,
        public readonly string $client,
        public readonly float $amountWithoutTax,
        public readonly int $taxRate,
        public readonly CarbonImmutable $billingDate,
    )
    {
    }
}
