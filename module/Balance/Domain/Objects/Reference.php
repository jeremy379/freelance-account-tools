<?php

namespace Module\Balance\Domain\Objects;

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
