<?php

namespace Module\Expense\Domain;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Exception\ExpenseNotFound;

interface ExpenseRepository
{
    public function fetchBetween(CarbonImmutable $from, CarbonImmutable $to): array;
    /**
     * @throws ExpenseNotFound
     */
    public function byReference(string $reference): Expense;

    public function save(Expense $expense): void;
}
