<?php

namespace Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\Expense\Domain\Objects\CategoryValue;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Tests\FakeClock;

class BillFactory extends Factory
{
    protected $model = EloquentBill::class;

    public function definition(): array
    {
        return [
            'reference' => $this->faker->uuid,
            'client' => $this->faker->company,
            'amount' => 50051,
            'tax_rate' => 21,
            'billing_datetime' => (new FakeClock())->now(),
        ];
    }
}
