<?php

namespace Module\Expense\Infrastructure\Repository;

use Module\Expense\Domain\Expense;
use Module\Expense\Domain\Objects\Amount;
use Module\Expense\Domain\Objects\CategoryValue;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Domain\Objects\Provider;
use Module\Expense\Domain\Objects\Reference;
use Module\Expense\Domain\Objects\TaxRate;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;

class ExpenseDomainFactory
{
    public function __invoke(EloquentExpense $expense): Expense
    {
        return Expense::restore(
            Reference::fromString($expense->reference),
            CategoryValue::from($expense->category),
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
}