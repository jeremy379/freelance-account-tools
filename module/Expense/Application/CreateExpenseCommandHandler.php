<?php

namespace Module\Expense\Application;

use Module\Expense\Domain\Exception\CannotCreateExpense;
use Module\Expense\Domain\Exception\ExpenseNotFound;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Domain\Objects\Amount;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Domain\Objects\Provider;
use Module\Expense\Domain\Objects\Reference;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\EventDispatcher;
use Module\SharedKernel\Domain\VatRate;

class CreateExpenseCommandHandler
{
    public function __construct(
        private readonly ExpenseRepository $repository,
        private readonly EventDispatcher $eventDispatcher,
    ) {
    }

    public function handle(CreateExpenseCommand $command): void
    {
        try {
            $this->repository->byReference($command->reference);
            throw CannotCreateExpense::referenceAlreadyExists($command->reference);
        } catch (ExpenseNotFound) {

            $expense = Expense::record(
                Reference::fromString($command->reference),
                Category::from(strtoupper($command->category)),
                Provider::fromString($command->provider),
                Amount::fromFloat($command->amount),
                match ($command->taxRate) {
                    0, 'exempt' => VatRate::exempt(),
                    6 => VatRate::rate6(),
                    20 => VatRate::rate20(),
                    21 => VatRate::rate21(),
                    default => VatRate::includedAndNotRefundable()
                },
                CountryCode::from(strtoupper($command->countryCode)),
            );

            if ($command->paymentDate) {
                $expense = $expense->pay($command->paymentDate);
            }

            $this->repository->save($expense);

            $this->eventDispatcher->dispatch(...$expense->popEvents());
        }
    }
}
