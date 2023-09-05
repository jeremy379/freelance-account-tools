<?php

namespace Module\Reporting\Domain\Config;

use Webmozart\Assert\Assert;

class SocialContributionConfig
{
    private function __construct(
        private array $slices,
        private array $finalSlice,
        private float $managingFee,
    )
    {
    }

    public static function loadConfiguration(int $yearToLoad, array $config)
    {
        $config = $config[$yearToLoad] ?? throw new \InvalidArgumentException('The configuration doesn\'t contains the year ' . $yearToLoad);

        return new self(
            self::checkSlice($config['slices']),
            self::checkFinalSlice($config['final_slice']),
            $config['managing_fees_rate']
        );
    }

    public function isAboveLastSliceThreshold(float $amount): bool
    {
        return $amount >= $this->finalSlice['from'];
    }

    public function lastThresholdFixedAmount(): float
    {
        return $this->finalSlice['fixed_amount'];
    }

    public function slices(): array
    {
        return $this->slices;
    }

    public function managingFeeRate(): float
    {
        return $this->managingFee;
    }

    private static function checkSlice(array $slices): array {
        foreach($slices as $slice) {
            Assert::keyExists($slice, 'from');
            Assert::keyExists($slice, 'to');
            Assert::keyExists($slice, 'rate');
        }

        return $slices;
    }

    private static function checkFinalSlice(array $slice): array {
        Assert::keyExists($slice, 'from');
        Assert::keyExists($slice, 'fixed_amount');
        return $slice;
    }
}
