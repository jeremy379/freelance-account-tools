<?php

namespace Module\Billing\Domain\Events;

class BillPaid
{
    public function __construct(public readonly string $billReference, public readonly int $amountPayed)
    {
    }
}
