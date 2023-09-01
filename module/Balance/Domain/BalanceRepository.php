<?php

namespace Module\Balance\Domain;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Objects\BalanceType;

interface BalanceRepository
{
    public function fetchBetween(BalanceType $type, CarbonImmutable $from, ?CarbonImmutable $to): array;

    public function save(Balance $balance): void;
}
