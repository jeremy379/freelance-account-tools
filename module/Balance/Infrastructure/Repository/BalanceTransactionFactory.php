<?php

namespace Module\Balance\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Balance;
use Module\Balance\Domain\Objects\Amount;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Domain\Objects\Reference;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;

class BalanceTransactionFactory
{
    public function __invoke(EloquentBalanceTransaction $balanceTransaction)
    {
        return Balance::restore(
            Amount::fromStoredInt($balanceTransaction->amount),
            BalanceType::from($balanceTransaction->type),
            Reference::fromString($balanceTransaction->reference),
            CarbonImmutable::parse($balanceTransaction->occurred_on)
        );
    }
}
