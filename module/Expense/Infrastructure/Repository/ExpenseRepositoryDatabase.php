<?php

namespace Module\Expense\Infrastructure\Repository;

use Module\Expense\Domain\Exception\ExpenseNotFound;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\SavingMode;

class ExpenseRepositoryDatabase implements ExpenseRepository
{
    public function byReference(string $reference): Expense
    {
        $expense = EloquentExpense::where('reference', $reference)->first();

        if(!$expense) {
            throw ExpenseNotFound::byReference($reference);
        }

        return $expense;
    }

    public function save(Expense $expense): void
    {
        if($expense->savingMode() === SavingMode::CREATE) {
            EloquentExpense::create([
                'reference' => $expense->reference,
                'category' => $expense->category,
                'provider' => $expense->provider,
                'amount' => $expense->amount,
                'tax_rate' => $expense->taxRate,
                'country_code' => $expense->countryCode,
            ]);
        }
    }
}
