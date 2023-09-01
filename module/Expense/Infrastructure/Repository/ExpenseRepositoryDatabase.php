<?php

namespace Module\Expense\Infrastructure\Repository;

use Module\Expense\Domain\Exception\ExpenseNotFound;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Domain\Objects\Amount;
use Module\Expense\Domain\Objects\Category;
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

        return Expense::restore(
            Reference::fromString($expense->reference),
            Category::from($expense->category),
            Provider::fromString($expense->provider),
            Amount::fromStoredInt($expense->amount),
            match($expense->tax_rate) {
                0 => TaxRate::exempt(),
                6 => TaxRate::rate6(),
                20 => TaxRate::rate20(),
                21 => TaxRate::rate21(),
                default => TaxRate::includedAndNotRefundable()
            },
            CountryCode::from($expense->country_code),
        );
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
