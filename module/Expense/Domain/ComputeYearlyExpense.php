<?php

namespace Module\Expense\Domain;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Expense\Domain\Objects\YearlyExpense;

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

        $sumAllExpenses = 0;
        $sumDeductibleExpense = 0;
        $vatToRequest = 0;
        foreach($expenses as $expense) {
            $expenseAmount = $expense->expense->amount->toInt();
            $sumAllExpenses += $expenseAmount;

            $category = $expense->expense->category;
            $deductibleRate = $this->configuration->deductibilityRateFor($category);

            $expenseAmount *= 1 + ($expense->expense->taxRate->rate() / 100);

            if($expense->expense->taxRate->isReverseCharge()) {
                $vatAmount = $expenseAmount * -0.21;
            } else {
                if (!$this->configuration->isVATCanBeRefundIn($expense->expense->countryCode)) {
                    $vatAmount = 0;
                } else {
                    $vatAmount = $expenseAmount * ($expense->expense->taxRate->rate() / 100);
                }
            }

            $sumDeductibleExpense += $expenseAmount * $deductibleRate;
            $vatToRequest += $vatAmount * $deductibleRate;
        }

        return new YearlyExpense($sumAllExpenses / 100, $sumDeductibleExpense / 100 ,count($expenses), $vatToRequest/100, $year);
    }
}
