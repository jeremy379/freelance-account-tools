<?php

namespace Module\Expense\Domain\Objects;

class TaxRate
{
    private function __construct(public readonly int $taxRatePercentage) {

    }

    public static function rate21(): TaxRate
    {
        return new self(21);
    }

    public static function rate20(): TaxRate
    {
        return new self(20);
    }

    public static function rate6(): TaxRate
    {
        return new self(6);
    }

    public static function exempt(): TaxRate
    {
        return new self(0);
    }

    public static function includedAndNotRefundable(): TaxRate
    {
        return new self(0);
    }
}
