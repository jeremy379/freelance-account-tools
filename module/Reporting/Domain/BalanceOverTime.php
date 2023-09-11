<?php

namespace Module\Reporting\Domain;

use Carbon\CarbonImmutable;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Module\Balance\Domain\Objects\Amount;

class BalanceOverTime implements Countable, Arrayable
{
    private ?int $minValue = null;
    private ?int $maxValue = null;

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

        $newBalances = new self($balances);
        $newBalances->maxValue = $this->maxValue;
        $newBalances->minValue = $this->minValue;

        if($this->minValue === null || $balanceOnDatetime->amount->toInt() < $this->minValue) {
            $newBalances->minValue = $balanceOnDatetime->amount->toInt();
        }

        if($this->maxValue === null || $balanceOnDatetime->amount->toInt() > $this->maxValue) {
            $newBalances->maxValue = $balanceOnDatetime->amount->toInt();
        }

        return $newBalances;
    }

    public function first(): ?BalanceOnDatetime
    {
        return reset($this->balances) ?? null;
    }

    public function last(): ?BalanceOnDatetime
    {
        return end($this->balances) ?? null;
    }

    public function count(): int
    {
        return count($this->balances);
    }

    public function toArray(): array
    {
        return $this->balances;
    }

    public function min(): int
    {
        return $this->minValue ?? 0;
    }

    public function max(): int
    {
        return $this->maxValue ?? 0;
    }

    public function isEmpty(): bool
    {
        return empty($this->balances);
    }

    /**
     * Group Balance recorded on the same date (Y-m-d). This will sum the amount for this day.
     */
    public function groupByDate(string $granularity): BalanceOverTime
    {
        if(!in_array($granularity, ['week', 'month'])) {
            throw new \InvalidArgumentException('Granularity must be either month or week');
        }

        $balancesByDays = [];

        foreach($this->balances as $balance) {
            $granuledBalanceDate = match($granularity) {
                'month' => $balance->datetime->startOfMonth()->toDateString(),
                'week' => $balance->datetime->startOfWeek()->toDateString(),
            };

            $amount = $balance->amount;
            if(isset($balancesByDays[$granuledBalanceDate])) {
                $amount = Amount::fromStoredInt($amount->toInt() + $balancesByDays[$granuledBalanceDate]->toInt());
            }

            $balancesByDays[$granuledBalanceDate] = $amount;
        }

        $balanceOverTime = self::new();

        foreach($balancesByDays as $dateString => $amountObject) {
            $balanceOverTime = $balanceOverTime->with(
                new BalanceOnDatetime($amountObject, CarbonImmutable::parse($dateString))
            );
        }

        return $balanceOverTime;
    }
}
