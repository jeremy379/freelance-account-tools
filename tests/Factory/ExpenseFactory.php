<?php

namespace Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\Category;

class ExpenseFactory extends Factory
{
    protected $model = EloquentExpense::class;

    public function definition(): array
    {
        return [
            'reference' => $this->faker->uuid(),
            'category' => Category::CAR->value,
            'provider' => $this->faker->name,
            'amount' => $this->faker->randomNumber(3),
            'tax_rate' => $this->faker->randomElement([0, 21, 6, 20]),
            'country_code' => CountryCode::BE->value,
        ];
    }
}
