<?php

namespace Module\Reporting\Domain;

class BalanceOverTime
{
    private function __construct(private array $balances = [])
    {
    }

    public static function new(): BalanceOverTime
    {
        return new self([]);
    }

    public function with(BalanceOnDatetime $balanceOnDatetime): BalanceOverTime
    {
        $balances = $this->balances;
        $balances[$balanceOnDatetime->datetime->timestamp] = $balanceOnDatetime;

        ksort($balances);

        return $balances;
    }

    public function first(): ?BalanceOnDatetime
    {
        return $this->balances[0] ?? null;
    }
}
