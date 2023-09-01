<?php

namespace Module\Billing\Domain;

use Carbon\CarbonImmutable;

class Bill
{
    private function __construct(
        public readonly string $reference,
        public readonly string $client,
        public readonly string $amountWithoutTax,
        public readonly string $taxRate,
        public readonly CarbonImmutable $billingDate,
    ) {

    }
}
