<?php

namespace Module\Balance\Domain;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Objects\Amount;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Domain\Objects\Reference;

class Balance
{
    private function __construct(
        public readonly Amount $amount,
        public readonly BalanceType $type,
        public readonly Reference $reference,
        public readonly CarbonImmutable $datetime,
    )
    {
    }

    public static function restore(
        Amount $amount,
        BalanceType $type,
        Reference $reference,
        CarbonImmutable $datetime,
    ): Balance
    {
        return new self(
            $amount,
            $type,
            $reference,
            $datetime,
        );
    }
}
