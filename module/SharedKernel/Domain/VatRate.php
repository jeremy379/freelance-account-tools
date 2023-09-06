<?php

namespace Module\SharedKernel\Domain;

class VatRate
{
    private function __construct(public readonly int $taxRatePercentage) {

    }

    public static function fromStoredValue(int|string $taxRatePercentage): VatRate
    {
        return match($taxRatePercentage) {
            0, 'exempt' => VatRate::exempt(),
            'intracom' => VatRate::intraCom(),
            'includedAndNotRefundable' => VatRate::includedAndNotRefundable(),
            6 => VatRate::rate6(),
            20 => VatRate::rate20(),
            21 => VatRate::rate21(),
            default => VatRate::exempt()
        };
    }

    public static function values(): array
    {
        return [
            '21' => 21, '20' => 20, '6' => 6, 'exempt' => 0, 'includedAndNotRefundable' => 0, 'intracom' => 0
        ];
    }

    public static function rate21(): VatRate
    {
        return new self(21);
    }

    public static function rate20(): VatRate
    {
        return new self(20);
    }

    public static function rate6(): VatRate
    {
        return new self(6);
    }

    public static function exempt(): VatRate
    {
        return new self(0);
    }

    public static function includedAndNotRefundable(): VatRate
    {
        return new self(0);
    }

    public static function intracom(): VatRate
    {
        return new self(0);
    }
}
