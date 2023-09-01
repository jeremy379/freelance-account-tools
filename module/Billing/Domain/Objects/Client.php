<?php

namespace Module\Billing\Domain\Objects;

class Client
{
    private function __construct(public readonly string $value)
    {
    }

    public static function fromString(string $provider): Client
    {
        return new self($provider);
    }
}
