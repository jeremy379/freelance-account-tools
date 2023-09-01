<?php

namespace Module\Expense\Domain;

interface ExpenseRepository
{
    public function save(Expense $expense): void;
}
