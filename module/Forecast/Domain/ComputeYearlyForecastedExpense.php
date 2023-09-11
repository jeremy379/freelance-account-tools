<?php

namespace Module\Forecast\Domain;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Domain\Objects\YearlyExpense;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\VatRate;

class ComputeYearlyForecastedExpense
{
    public function __construct(
        private readonly ForecastRepository $repository,
        private readonly DeductibilityConfiguration $configuration
    ) {

    }

    public function compute(int $year, bool $onlyFutureMonth = false): YearlyExpense
    {
        $from = CarbonImmutable::now()->setYear($year)->startOfYear();

        $expenses = $this->repository->expenseForecastedForYear($from, $onlyFutureMonth);

        $sumAllExpenses = $sumDeductibleExpense = $vatToRequest = $taxProvisioned = $socialContributionPaid = 0;

        foreach($expenses as $forecastedExpense) {
            if($forecastedExpense->category === Category::TAX) {
                continue; //We do not process this type of expense. This is mostly a row saying "Hey, I paid that amount of tax!"
            }

            $expenseAmount = $forecastedExpense->amount->toInt();

            if($forecastedExpense->category === Category::TAX_PREVISION) {
                $taxProvisioned += $expenseAmount; //This is for reporting purpose. These amount are just cash moved to specific bank account.
                continue;
            }
            if($forecastedExpense->category === Category::SOCIAL_CHARGE) {
                $socialContributionPaid += $expenseAmount;
                continue;
            }

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

        return new YearlyExpense(
            $sumAllExpenses / 100,
            $sumDeductibleExpense / 100, count($expenses),
            $vatToRequest / 100,
            $taxProvisioned / 100,
            $socialContributionPaid / 100,
            $year
        );
    }
}
