<?php

namespace Module\Reporting\Domain;

use Module\Reporting\Domain\Config\TaxConfig;

class TaxCalculator
{
    private array $details;

    public function __construct(private TaxConfig $taxConfig)
    {
    }

    public function compute(float $taxableIncomeAfterAllDeduction, string $companyQGZipCode): float
    {
        $tax = 0;
        $rest = $taxableIncomeAfterAllDeduction;

        $sliced = $this->splitAmountInSlice($this->taxConfig->slices(), $rest);

        $this->details = $sliced;

        foreach($sliced as $slice) {
            $amountAsInt = (int) ($slice['amount'] * 100);
            $tax += $amountAsInt * $slice['rate']/100;
        }

        $cityTaxRate = 1 + $this->taxConfig->cityTaxRate($companyQGZipCode)/100;

        return $this->commercialRound(($tax * $cityTaxRate)/100, 2);
    }

    public function computationDetails(): array
    {
        if(empty($this->details)) {
            throw new \Exception('To get details, run the computations first', 400);
        }
        return $this->details;
    }

    private function splitAmountInSlice(array $slices, float $amount): array
    {
        $sliced = [];

        foreach($slices as $slice) {

            $outOfSlice = $amount < $slice['from'];

            if($outOfSlice) {
                continue;
            }

            $fullyInSlice = $amount >= $slice['from'] && $amount >= $slice['to'];
            $partlyInSlice = $amount >= $slice['from'] && $amount < $slice['to'];

            if($fullyInSlice) {
                $computedAmount = $slice['to'] - $slice['from'];
            } elseif($partlyInSlice) {
                $computedAmount = ((int) ($amount * 10000 - $slice['from'] * 10000)) / 10000;
            } else {
                $computedAmount = 0;
            }

            $sliced[] = [
                'rate' => $slice['rate'],
                'amount' => $computedAmount,
            ];
        }

        if($amount > $this->taxConfig->thresholdAfterLastSlice()) {
            $sliced[] = [
                'rate' => $this->taxConfig->finalRate(),
                'amount' => ((int) ($amount * 10000 - $this->taxConfig->thresholdAfterLastSlice() * 10000) / 10000),
            ];
        }

        return $sliced;
    }

    private function commercialRound(float $number, int $precision = 0): float {
        $factor = 10 ** $precision;
        $rounded = round($number * $factor);
        return $rounded / $factor;
    }
}
