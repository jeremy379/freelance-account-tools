<?php

namespace Module\SharedKernel\Domain;

class VatRate
{
    public const EXEMPT = 'exempt';
    public const INTRACOM = 'intracom';
    public const REVERSE_CHARGE = 'reverse-charge';
    public const INCLUDED_NOT_REFUNDABLE = 'included-not-refundable';

    private function __construct(private readonly string $taxValue)
    {
    }

    public static function fromStoredValue(string $taxRatePercentage): VatRate
    {
        return match($taxRatePercentage) {
            '0' => VatRate::rate0(),
            self::EXEMPT => VatRate::exempt(),
            self::INTRACOM => VatRate::intraCom(),
            self::INCLUDED_NOT_REFUNDABLE => VatRate::includedAndNotRefundable(),
            self::REVERSE_CHARGE => VatRate::reverseCharge(),
            '6' => VatRate::rate6(),
            '10' => VatRate::rate10(),
            '20' => VatRate::rate20(),
            '21' => VatRate::rate21(),
            default => throw new \InvalidArgumentException('Tax value ' . $taxRatePercentage . ' is not an allowed value')
        };
    }

    public static function values(): array
    {
        return [
            '21' => 21, '20' => 20, '10' => 10, '6' => 6, '0' => 0, self::EXEMPT => self::EXEMPT, self::INCLUDED_NOT_REFUNDABLE => self::INCLUDED_NOT_REFUNDABLE, self::INTRACOM => self::INTRACOM, self::REVERSE_CHARGE => self::REVERSE_CHARGE,
        ];
    }

    public function rate(): int
    {
        if(is_numeric($this->taxValue)) {
            return $this->taxValue;
        }

        return 0;
    }

    public function value(): string
    {
        return $this->taxValue;
    }

    public static function rate21(): VatRate
    {
        return new self('21');
    }

    public static function rate20(): VatRate
    {
        return new self('20');
    }

    public static function rate6(): VatRate
    {
        return new self('6');
    }

    public static function rate10(): VatRate
    {
        return new self('10');
    }

    public static function rate0(): VatRate
    {
        return new self('0');
    }

    public static function exempt(): VatRate
    {
        return new self('exempt');
    }

    public static function includedAndNotRefundable(): VatRate
    {
        return new self(self::INCLUDED_NOT_REFUNDABLE);
    }

    public static function intracom(): VatRate
    {
        return new self(self::INTRACOM);
    }

    public static function reverseCharge(): VatRate
    {
        return new self(self::REVERSE_CHARGE);
    }

    public function isIntracCom(): bool
    {
        return $this->taxValue === self::INTRACOM;
    }

    public function isReverseCharge(): bool
    {
        return $this->taxValue === self::REVERSE_CHARGE;
    }
}
