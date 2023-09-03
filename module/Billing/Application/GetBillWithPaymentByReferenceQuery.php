<?php

namespace Module\Billing\Application;

use Module\SharedKernel\Domain\Query;

class GetBillWithPaymentByReferenceQuery implements Query
{
    public function __construct(public readonly string $reference)
    {
    }
}
