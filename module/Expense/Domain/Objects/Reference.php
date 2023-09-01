<?php

namespace Module\Expense\Domain\Objects;

class Reference
{
    private function __construct(public readonly string $value)
    {
    }

    public static function fromString(string $reference): Reference
    {
        return new self($reference);
    }
}
