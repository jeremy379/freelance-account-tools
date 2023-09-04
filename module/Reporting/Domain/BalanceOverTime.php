<?php

namespace Module\Reporting\Domain;

use Countable;
use Illuminate\Contracts\Support\Arrayable;

class BalanceOverTime implements Countable, Arrayable
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

    public function count(): int
    {
        return count($this->balances);
    }

    public function toArray(): array
    {
        return $this->balances;
    }
}
