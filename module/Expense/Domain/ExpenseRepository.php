<?php

namespace Module\Expense\Domain;

use Module\Expense\Domain\Exception\ExpenseNotFound;

interface ExpenseRepository
{
    /**
     * @throws ExpenseNotFound
     */
    public function byReference(string $reference): Expense;

    public function save(Expense $expense): void;
}
