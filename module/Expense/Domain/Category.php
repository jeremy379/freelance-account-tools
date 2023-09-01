<?php

namespace Module\Expense\Domain;

class Category
{
    private function __construct(
        public readonly string $name,
        public readonly int $percentOfDeductibility,
    )
    {
    }
}
