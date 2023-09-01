<?php

namespace Module\Expense\Application;

use Module\Expense\Domain\ExpenseRepository;
use Module\SharedKernel\Domain\EventDispatcher;

class CreateExpenseCommandHandler
{
    public function __construct(
        private ExpenseRepository $repository,
        private EventDispatcher $eventDispatcher,
    )
    {
    }

    public function handle(CreateExpenseCommand $command): void
    {

    }
}
