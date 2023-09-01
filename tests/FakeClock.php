<?php

namespace Tests;

use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class FakeClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return CarbonImmutable::parse('2023-09-01 09:00:00'); //Friday
    }
}
