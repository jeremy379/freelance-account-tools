<?php

namespace Module\Expense\Domain;

use Carbon\CarbonImmutable;

class ExpenseWithPayment
{
    public function __construct(
        public readonly Expense $expense,
        public readonly CarbonImmutable $paidOn,
    ) {
    }
}
