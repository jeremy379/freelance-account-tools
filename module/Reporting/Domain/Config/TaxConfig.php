<?php

namespace Module\Reporting\Domain\Config;

class TaxConfig
{
    private function __construct(private array $slices, private int $rateAfterLastSlice, private float $thresholdAfterLastSlice, private float $exoneratedAmount, private int $cityTaxRate)
    {
    }

    public static function loadConfiguration(int $yearToLoad, array $config): TaxConfig
    {
        $config = $config[$yearToLoad] ?? throw new \InvalidArgumentException('The configuration doesn\'t contains the year ' . $yearToLoad);

        return new self(
            $config['slices'],
            $config['rate_after_last_slice'],
            $config['threshold_after_last_slice'],
            $config['exoneratedAmount'],
            $config['rate_city_tax']
        );
    }

    public function slices(): array
    {
        return $this->slices;
    }

    public function exoneratedAmount(): float
    {
        return $this->exoneratedAmount;
    }

    public function finalRate(): int
    {
        return $this->rateAfterLastSlice;
    }

    public function thresholdAfterLastSlice(): float
    {
        return $this->thresholdAfterLastSlice;
    }

    public function cityTaxRate(string $zipcode)
    {
        return $this->cityTaxRate;
    }
}
