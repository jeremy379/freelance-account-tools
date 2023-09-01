<?php

namespace Module\Expense\Infrastructure\Repository;

use Module\Expense\Domain\Exception\ExpenseNotFound;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Domain\Objects\Amount;
use Module\Expense\Domain\Objects\CategoryValue;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Domain\Objects\Provider;
use Module\Expense\Domain\Objects\Reference;
use Module\Expense\Domain\Objects\TaxRate;
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

        return (new ExpenseDomainFactory())($expense);
    }

    public function save(Expense $expense): void
    {
        if($expense->savingMode() === SavingMode::CREATE) {
            EloquentExpense::create([
                'reference' => $expense->reference->value,
                'category' => $expense->category->value,
                'provider' => $expense->provider->value,
                'amount' => $expense->amount->toInt(),
                'tax_rate' => $expense->taxRate->taxRatePercentage,
                'country_code' => $expense->countryCode->value,
            ]);
        }
    }
}
