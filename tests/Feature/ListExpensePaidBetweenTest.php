<?php

namespace Feature;

use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Tests\TestCase;

class ListExpensePaidBetweenTest extends TestCase
{
    public function testItListExpensesInTimeframe()
    {
        EloquentExpense::factory()->count(5)->create();

    }
}
