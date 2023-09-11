<?php

namespace Module\Balance\Domain\Objects;

use Webmozart\Assert\Assert;

class Amount
{
    private function __construct(private readonly int $amount)
    {
    }

    public static function fromFloat(float $amount): Amount
    {
        $amount = (int) $amount * 100;

        Assert::positiveInteger($amount);

        return new self($amount);
    }

    public static function fromStoredInt(int $amount): Amount
    {
        Assert::integer($amount);

        return new self($amount);
    }

    public function toInt(): int
    {
        return $this->amount;
    }

    public function toHumanFloat(): float
    {
        return $this->amount / 100;
    }
}
