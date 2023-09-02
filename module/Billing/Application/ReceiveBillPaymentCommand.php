<?php

namespace Module\Billing\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Command;

class ReceiveBillPaymentCommand implements Command
{
    public function __construct(
        public readonly string $reference,
        public readonly int $amountReceived,
        public readonly CarbonImmutable $paymentReceivedOn
    )
    {
    }
}
