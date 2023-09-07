<?php

namespace Module\Expense\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseWithPayment;
use Module\Expense\Domain\Objects\Amount;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Domain\Objects\Provider;
use Module\Expense\Domain\Objects\Reference;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\VatRate;

class ExpenseDomainFactory
{
    public function toExpense(EloquentExpense $expense): Expense
    {
        return Expense::restore(
            Reference::fromString($expense->reference),
            Category::from($expense->category),
            Provider::fromString($expense->provider),
            Amount::fromStoredInt($expense->amount),
            VatRate::fromStoredValue($expense->tax_rate),
            CountryCode::from($expense->country_code),
        );
    }

    public function toExpenseWithPayment(EloquentExpense $expense): ExpenseWithPayment
    {
        $expenseObject = $this->toExpense($expense);

        return new ExpenseWithPayment($expenseObject, CarbonImmutable::parse($expense->payment->occurred_on));
    }
}
