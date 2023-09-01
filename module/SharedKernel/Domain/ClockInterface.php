<?php

namespace Module\SharedKernel\Domain;

use Carbon\CarbonImmutable;

interface ClockInterface
{
    public function now(): CarbonImmutable;
}
