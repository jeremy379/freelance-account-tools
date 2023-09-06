<?php

namespace Module\Forecast\Domain\Objects;

class ForecastAmount
{
    private function __construct(private int $amount)
    {
    }

    public static function fromFloat(float $amount): ForecastAmount
    {
        return new self($amount * 100);
    }

    public function toInt(): int
    {
        return $this->amount;
    }
}
