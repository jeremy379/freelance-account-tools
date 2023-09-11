<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Objects\YearlyBill;

class ComputeYearlyForecastedIncome
{
    public function __construct(private ForecastRepository $repository)
    {
    }

    public function compute(int $year, bool $onlyFutureMonth = false): YearlyBill
    {
        $datetime = CarbonImmutable::now()->setYear($year)->startOfYear();

        $bills = $this->repository->incomeForecastedForYear($datetime, $onlyFutureMonth);

        $totalTurnover = 0;
        $totalVatCollected = 0;

        foreach($bills as $bill) {
            $totalTurnover += $bill->amount->toInt();
            $totalVatCollected += $bill->amount->toInt() * ($bill->vatRate->rate() / 100);
        }

        return new YearlyBill(
            $year,
            $totalTurnover / 100,
            $totalVatCollected / 100,
            count($bills)
        );
    }
}
