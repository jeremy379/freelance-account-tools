<?php

namespace Module\SharedKernel\Domain;

interface DomainEvent
{
    public function name(): string;

    public function payload(): array;
}
