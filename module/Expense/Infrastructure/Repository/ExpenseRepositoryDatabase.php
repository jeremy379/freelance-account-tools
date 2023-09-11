<?php

namespace Module\Expense\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Module\Expense\Domain\Exception\ExpenseNotFound;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\SavingMode;

class ExpenseRepositoryDatabase implements ExpenseRepository
{
    public function __construct(private ExpenseDomainFactory $expenseDomainFactory)
    {
    }

    public function byReference(string $reference): Expense
    {
        $expense = EloquentExpense::where('reference', $reference)->first();

        if(!$expense) {
            throw ExpenseNotFound::byReference($reference);
        }

        return $this->expenseDomainFactory->toExpense($expense);
    }

    public function save(Expense $expense): void
    {
        if($expense->savingMode() === SavingMode::CREATE) {
            EloquentExpense::create([
                'reference' => $expense->reference->value,
                'category' => $expense->category->value,
                'provider' => $expense->provider->value,
                'amount' => $expense->amount->toInt(),
                'tax_rate' => $expense->taxRate->value(),
                'country_code' => $expense->countryCode->value,
            ]);
        }
    }

    public function fetchBetween(CarbonImmutable $from, CarbonImmutable $to): array
    {
        return EloquentExpense::query()
            ->whereHas('payment', function (Builder $query) use ($from, $to) {
                $query->where('occurred_on', '>=', $from);

                if($to) {
                    $query->where('occurred_on', '<=', $to);
                }
            })
            ->get()
            ->transform(fn (EloquentExpense $expense) => $this->expenseDomainFactory->toExpenseWithPayment($expense))
            ->toArray()
        ;
    }
}
