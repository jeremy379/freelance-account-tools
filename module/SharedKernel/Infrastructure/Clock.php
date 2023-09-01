<?php

namespace Module\SharedKernel\Infrastructure;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\ClockInterface;

class Clock implements ClockInterface
{
    public function now(): CarbonImmutable
    {
        return CarbonImmutable::now();
    }
}
