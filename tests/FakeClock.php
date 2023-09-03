<?php

namespace Tests;

use Carbon\CarbonImmutable;
use Module\SharedKernel\Domain\ClockInterface;

class FakeClock implements ClockInterface
{
    public function now(): CarbonImmutable
    {
        return CarbonImmutable::parse('2023-09-01 09:00:00')->startOfSecond(); //Friday
    }
}
