<?php

namespace Module\SharedKernel\Domain;

interface EventDispatcher
{
    public function dispatch(DomainEvent ...$events): void;
}
