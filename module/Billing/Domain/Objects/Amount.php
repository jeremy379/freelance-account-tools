<?php

namespace Module\Billing\Domain\Objects;

use Webmozart\Assert\Assert;

class Amount
{
    private function __construct(private readonly int $amount)
    {
    }

    public static function fromFloat(float $amount): Amount
    {
        $amount = (int) ($amount * 100);

        Assert::positiveInteger($amount);

        return new self($amount);
    }

    public static function fromStoredInt(int $amount): Amount
    {
        Assert::positiveInteger($amount);
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

    public function withTax(TaxRate $taxRate): Amount
    {
        $amountInt = $this->amount + ($this->amount * $taxRate->taxRatePercentage / 100);

        return new self($amountInt);
    }
}
