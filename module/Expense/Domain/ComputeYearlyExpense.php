<?php

namespace Module\Expense\Domain;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Expense\Domain\Objects\YearlyExpense;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\VatRate;

class ComputeYearlyExpense
{
    public function __construct(private readonly ExpenseRepository $expenseRepository, private readonly DeductibilityConfiguration $configuration)
    {
    }

    public function compute(int $year): YearlyExpense
    {
        $from = CarbonImmutable::now()->setYear($year)->startOfYear();
        $to = CarbonImmutable::now()->setYear($year)->endOfYear();

        $expenses = $this->expenseRepository->fetchBetween($from, $to);

        $sumAllExpenses = $sumDeductibleExpense = $vatToRequest = $taxProvisioned = $socialContributionPaid = 0;
        foreach ($expenses as $expense) {
            if ($expense->expense->category === Category::TAX) {
                continue; //We do not process this type of expense. This is mostly a row saying "Hey, I paid that amount of tax!"
            }

            $expenseAmount = $expense->expense->amount->toInt();

            if ($expense->expense->category === Category::TAX_PREVISION) {
                $taxProvisioned += $expenseAmount; //This is for reporting purpose. These amount are just cash moved to specific bank account.

                continue;
            }
            if ($expense->expense->category === Category::SOCIAL_CHARGE) {
                $socialContributionPaid += $expenseAmount;

                continue;
            }

            $sumAllExpenses += $expenseAmount;

            $category = $expense->expense->category;
            $deductibleRate = $this->configuration->deductibilityRateFor($category);

            if ($expense->expense->taxRate->isReverseCharge()) {
                $vatAmount = $expenseAmount * -1 * (VatRate::rate21()->rate() / 100);
            } else {
                if (! $this->configuration->isVATCanBeRefundIn($expense->expense->countryCode)) {
                    $vatAmount = 0;
                    $expenseAmount *= 1 + ($expense->expense->taxRate->rate() / 100);
                } else {
                    $vatAmount = $expenseAmount * ($expense->expense->taxRate->rate() / 100) * $deductibleRate;
                }
            }

            $sumDeductibleExpense += $expenseAmount * $deductibleRate;
            $vatToRequest += $vatAmount;
        }

        return new YearlyExpense(
            $sumAllExpenses / 100,
            $sumDeductibleExpense / 100,
            count($expenses),
            $vatToRequest / 100,
            $taxProvisioned / 100,
            $socialContributionPaid / 100,
            $year
        );
    }
}
