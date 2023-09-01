<?php

namespace Module\Expense\Infrastructure\Repository;

use Module\Expense\Domain\Expense;
use Module\Expense\Domain\ExpenseRepository;

class ExpenseRepositoryDatabase implements ExpenseRepository
{
    public function save(Expense $expense): void
    {
        // TODO: Implement save() method.
    }
}
