<?php

namespace Module\Billing\Domain\Objects;

class TaxRate
{
    private function __construct(public readonly int $taxRatePercentage) {

    }

    public static function values(): array
    {
        return [
            '21' => 21, '20' => 20, '6' => 6, 'exempt' => 0, 'intracom' => 0,
        ];
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

    public static function intraCom(): TaxRate
    {
        return new self(0);
    }
}
