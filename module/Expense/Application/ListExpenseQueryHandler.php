<?php

namespace Module\Expense\Application;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\Query;

class ListExpenseQueryHandler
{
    public function handle(ListExpensePaidBetweenQuery $query): array
    {
        return [];
    }
}
