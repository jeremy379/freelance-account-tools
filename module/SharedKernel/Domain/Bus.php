<?php

namespace Module\SharedKernel\Domain;

interface Bus
{
    public function dispatch(Command|Query $action): mixed;
}
