<?php

namespace Module\Expense\Infrastructure;

use Module\Expense\Domain\ComputeYearlyExpense;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Expense\Domain\ExpenseRepository;

class ExpenseFacade
{
    public function __construct(private ExpenseRepository $repository)
    {

    }

    public function getComputedYearlyExpense(int $year): array
    {
        $computeService = new ComputeYearlyExpense($this->repository, DeductibilityConfiguration::loadConfiguration(config('calculator.deductibility')));

        return $computeService->compute($year)->toArray();
    }
}
