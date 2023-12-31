<?php

namespace Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Tests\FakeClock;

class BalanceFactory extends Factory
{
    protected $model = EloquentBalanceTransaction::class;

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
