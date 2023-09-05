<?php

namespace Module\Reporting\Domain;

use Module\Reporting\Domain\Config\SocialContributionConfig;

class SocialContributionCalculator
{
    public const PERIODICITY = 'P3M';
    public const PERIOD_PER_YEAR = 4;
    private float $annualContribution = 0;

    public function __construct(private SocialContributionConfig $config)
    {
    }

    public function compute(float $netTaxableIncome): array
    {
        if ($this->config->isAboveLastSliceThreshold($netTaxableIncome)) {
            $this->annualContribution = $this->config->lastThresholdFixedAmount() * 100;
        } else {

            $amountStillToBeTaxed = $netTaxableIncome;

            foreach($this->config->slices() as $slice) {
                if($amountStillToBeTaxed > 0) {
                    [$amountInSlice, $amountStillToBeTaxed] = $this->splitAmountInSlice($slice, $amountStillToBeTaxed);

                    $ratePercent = $slice['rate'] / 100;
                    $intAmount = (int) ($amountInSlice * 100);

                    $annualContribution = $intAmount * $ratePercent;

                    $this->annualContribution += $annualContribution;
                }
            }
        }

        $managingFeePercent = $this->config->managingFeeRate() / 100;
        $annualContributionInt = $this->annualContribution;

        $this->annualContribution += $annualContributionInt * $managingFeePercent;

        return [
            'yearly_amount' => $this->commercialRound($this->annualContribution / 100 , 2),
            'periodic_amount' => $this->commercialRound(($this->annualContribution / self::PERIOD_PER_YEAR) / 100, 2),
            'period' => self::PERIODICITY,
        ];
    }

    private function splitAmountInSlice(array $slice, float $amount): array
    {
        $rest = 0;
        if($amount >= $slice['to']) {
            $rest = $amount - $slice['to'];
            $amount = $slice['to'];
        }

        return [$amount, $rest];

    }

    private function commercialRound(float $number, int $precision = 0): float {
        $factor = 10 ** $precision;
        $rounded = round($number * $factor);
        return $rounded / $factor;
    }
}
