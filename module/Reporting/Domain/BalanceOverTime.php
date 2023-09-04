<?php

namespace Module\Reporting\Domain;

use Module\Balance\Domain\Objects\Amount;

class BalanceOverTime
{
    /**
     * @param array<BalanceOnDatetime> $balances
     */
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

        return new self($balances);
    }

    public function first(): ?BalanceOnDatetime
    {
        return $this->balances[0] ?? null;
    }

    public function last(): ?BalanceOnDatetime
    {
        return end($this->balances);
    }
}
