<?php

namespace Module\Expense\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Query;

class ListExpensePaidBetweenQuery implements Query
{
    public function __construct(
        public readonly CarbonImmutable $from,
        public readonly ?CarbonImmutable $to,
    ) {
    }
}
