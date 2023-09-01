<?php

namespace Module\Expense\Domain\Objects;

class Category
{
    private function __construct(
        public readonly CategoryValue $name,
        public readonly int $percentOfDeductibility,
    )
    {
    }
}
