<?php

namespace Module\Balance\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Balance;
use Module\Balance\Domain\BalanceRepository;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;

class BalanceRepositoryDatabase implements BalanceRepository
{
    public function fetchBetween(BalanceType $type, CarbonImmutable $from, ?CarbonImmutable $to): array
    {
        $balanceTransactions = EloquentBalanceTransaction::query()
            ->where('type', $type->value)
            ->where('occurred_on', '>=', $from);

        if($to) {
            $balanceTransactions = $balanceTransactions->where('occurred_on', '<=', $to);
        }

        $factory = new BalanceTransactionFactory();

        return $balanceTransactions->get()->transform(fn (EloquentBalanceTransaction $transaction) => $factory($transaction))->toArray();
    }

    public function save(Balance $balance): void
    {
        EloquentBalanceTransaction::create([
            'type' => $balance->type->value,
            'reference' => $balance->reference->value,
            'amount' => $balance->amount->toInt(),
            'occurred_on' => $balance->datetime,
        ]);
    }
}
