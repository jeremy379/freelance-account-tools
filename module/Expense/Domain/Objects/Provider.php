<?php

namespace Module\Expense\Domain\Objects;

class Provider
{
    private function __construct(public readonly string $value)
    {
    }

    public static function fromString(string $provider): Provider
    {
        return new self($provider);
    }
}
