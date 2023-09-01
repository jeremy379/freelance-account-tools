<?php

namespace Module\Expense\Application;

use Module\Expense\Domain\Exception\ExpenseNotFound;
use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;
use Module\SharedKernel\Domain\EventDispatcher;

class CreateExpenseCommandHandler
{
    public function __construct(
        private readonly ExpenseRepository $repository,
        private readonly EventDispatcher   $eventDispatcher,
    )
    {
    }

    public function handle(CreateExpenseCommand $command): void
    {
        try {
            $this->repository->byReference($command->reference);
        } catch (ExpenseNotFound) {

            $expense = Expense::record();

            $this->repository->save($expense);

            $this->eventDispatcher->dispatch(...$expense->popEvents());
        }
    }
}
