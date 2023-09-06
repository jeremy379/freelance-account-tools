<?php

namespace Module\Billing\Domain;

use Carbon\CarbonImmutable;
use Module\Billing\Domain\Objects\YearlyBill;

class ComputeYearlyIncome
{
    public function __construct(private BillRepository $billRepository)
    {
    }

    public function compute(int $year)
    {
        $from = CarbonImmutable::now()->setYear($year)->startOfYear();
        $to = CarbonImmutable::now()->setYear($year)->endOfYear();

        $bills = $this->billRepository->fetchBetween($from, $to);

        $totalTurnover = 0;
        $totalVatCollected = 0;

        foreach($bills as $bill) {
            $totalTurnover += $bill->amountWithoutTax->toInt();
            $totalVatCollected += $bill->amountWithoutTax->toInt() * ($bill->taxRate->taxRatePercentage/100);
        }

        return new YearlyBill(
            $year,
            $totalTurnover / 100,
            $totalVatCollected / 100,
            count($bills)
        );
    }
}
