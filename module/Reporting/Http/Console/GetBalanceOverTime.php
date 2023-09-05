<?php

namespace Module\Reporting\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Reporting\Application\GetBalanceOverPeriodQuery;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\BalanceOverTime;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;

class GetBalanceOverTime extends Command
{
    protected $signature = 'reporting:balance';

    protected $description = 'Get balance over time';

    public function handle(ClockInterface $clock, Bus $bus): int
    {
        $from = $this->ask('From', $clock->now()->startOfYear()->toIso8601String());
        $to = $this->ask('To', $clock->now()->endOfYear()->toIso8601String());

        $query = new GetBalanceOverPeriodQuery(CarbonImmutable::parse($from), CarbonImmutable::parse($to));

        /** @var BalanceOverTime $balances */
        $balances = $bus->dispatch($query);

        if($balances->isEmpty())
        {
            $this->error('There is no entries in your balance');
            return self::INVALID;
        }

        $balances = $balances->groupByDate();

        $yScale = $this->yScale($balances->min(), $balances->max());
        $xScale = $this->xScale(
            $balances->first()->datetime->startOfDay(),
            $balances->last()->datetime->endOfDay()
        );

        $xScale = array_merge(['Amount'], $xScale);

        //Generate empty array matrix

        $rows = [];
        foreach($xScale as $xIndex => $date) {
            foreach($yScale as $yIndex => $amount) {
                if($xIndex === 0) {
                    $rows[$yIndex][0] = round($amount/100);
                } else {
                    $rows[$yIndex][$xIndex] = '';
                }
            }
        }

        $sumRowYIndex = $yIndex + 1;

        $rows[$sumRowYIndex][0] = 'Total';

        /** @var BalanceOnDatetime $balance */
        foreach($balances->toArray() as $timestamp => $balance) {
            //Check the right box in the matrix
            $xIndexToCheck = $this->getClosestPreviousDatetime($balance->datetime, $xScale);
            $yIndexToCheck = $this->getClosestPreviousAmount($balance->amount->toInt(), $yScale);

            $rows[$yIndexToCheck][$xIndexToCheck] = 'x';

            $rows[$sumRowYIndex][$xIndexToCheck] = $balance->amount->toHumanFloat();
        }

        $this->table($xScale, $rows);

        return self::SUCCESS;
    }

    private function yScale(int $min, int $max): array
    {
        $minPower = pow(10, strlen(abs($min)) - 1);
        $min = round($min/$minPower, 2) * $minPower;

        $maxPower = pow(10, strlen(abs($max)) - 1);
        $max = round($max/$maxPower, 2) * $maxPower;

        $step = 10 ** floor(log10(abs($min)));
        $result = [];

        for ($i = $max; $i >= $min; $i -= $step) {
            $result[] = $i;
        }

        $result[] = $i;

        return $result;
    }

    private function xScale(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $xScale = [];
        $diffInDays = $from->diffInDays($to);
        if($diffInDays < 100)
        {
            $granularity = $diffInDays/10;
            $granularityType = 'day';
        } else {
            $granularity = $from->diffInMonths($to);
            $granularityType = 'month';
        }

        $granularity = max($granularity, 1);

        $fromCopy = $from->copy();

        while ($fromCopy->lt($to)) {
            $xScale[] = $fromCopy->toDateString();

            $fromCopy = match($granularityType) {
                'day' => $fromCopy->addDays($granularity),
                'month' => $fromCopy->addMonths($granularity)
            };
        }

        return $xScale;
    }

    private function getClosestPreviousDatetime(CarbonImmutable $datetime, array $xScale): int
    {
        foreach($xScale as $index => $date) {
            if($date !== 'Amount') {
                $dateCarboned = CarbonImmutable::parse($date);

                if ($datetime->lte($dateCarboned)) {
                    return max($index, 1);
                }
            }
        }

        return 1;
    }

    private function getClosestPreviousAmount(int $amount, array $yScale): int
    {
        foreach($yScale as $index => $yAmount) {
            if($amount >= $yAmount) {
                return $index - 1;
            }
        }

        return 0;
    }
}
