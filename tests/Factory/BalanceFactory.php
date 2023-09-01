<?php

namespace Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalance;
use Module\Expense\Domain\Objects\CategoryValue;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Tests\FakeClock;

class BalanceFactory extends Factory
{
    protected $model = EloquentBalance::class;

    public function definition(): array
    {
        return [
            'type' => BalanceType::EXPENSE,
            'reference' => $this->faker->uuid,
            'amount' => $this->faker->randomNumber(3),
            'occurred_on' => (new FakeClock())->now(),
        ];
    }
}
