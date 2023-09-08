<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Domain\Objects\YearlyExpense;
use Module\SharedKernel\Domain\VatRate;

class ComputeYearlyForecastedExpense
{
    public function __construct(
        private readonly ForecastRepository $repository,
        private readonly DeductibilityConfiguration $configuration
    ){

    }

    public function compute(int $year, bool $onlyFutureMonth = false): YearlyExpense
    {
        $from = CarbonImmutable::now()->setYear($year)->startOfYear();

        $expenses = $this->repository->expenseForecastedForYear($from, $onlyFutureMonth);

        $sumAllExpenses = 0;
        $sumDeductibleExpense = 0;
        $vatToRequest = 0;
        foreach($expenses as $forecastedExpense) {
            $expenseAmount = $forecastedExpense->amount->toInt();
            $sumAllExpenses += $expenseAmount;

            $category = $forecastedExpense->category;
            $deductibleRate = $this->configuration->deductibilityRateFor($category);

            if($forecastedExpense->vatRate->isReverseCharge()) {
                $vatAmount = $expenseAmount * -1 *  (VatRate::rate21()->rate() / 100);
            } else {
                if (!$this->configuration->isVATCanBeRefundIn($forecastedExpense->countryCodeWhereExpenseIsMade)) {
                    $vatAmount = 0;
                    $expenseAmount *= 1 + ($forecastedExpense->vatRate->rate() / 100);
                } else {
                    $vatAmount = $expenseAmount * ($forecastedExpense->vatRate->rate() / 100) * $deductibleRate;
                }
            }

            $sumDeductibleExpense += $expenseAmount * $deductibleRate;
            $vatToRequest += $vatAmount;
        }

        return new YearlyExpense($sumAllExpenses / 100, $sumDeductibleExpense / 100 ,count($expenses), $vatToRequest/100, $year);
    }
}
