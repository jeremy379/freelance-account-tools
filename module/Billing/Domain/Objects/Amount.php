<?php

namespace Module\Billing\Domain\Objects;

use Module\SharedKernel\Domain\VatRate;
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

    public function withTax(VatRate $taxRate): Amount
    {
        $amountInt = (int) round($this->amount + ($this->amount * $taxRate->rate() / 100));

        return new self($amountInt);
    }
}
