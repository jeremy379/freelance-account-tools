<?php

namespace Module\Reporting\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Reporting\Application\GetBalanceOverPeriodQuery;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\BalanceOverTime;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;

use function Laravel\Prompts\error;
use function Laravel\Prompts\text;

class GetBalanceOverTime extends Command
{
    protected $signature = 'reporting:balance';

    protected $description = 'Get balance over time';

    public function handle(ClockInterface $clock, Bus $bus): int
    {
        $from = text('From', $clock->now()->startOfYear()->toIso8601String(), $clock->now()->startOfYear()->toIso8601String());
        $to = text('To', $clock->now()->endOfYear()->toIso8601String(), $clock->now()->endOfYear()->toIso8601String());

        $query = new GetBalanceOverPeriodQuery(CarbonImmutable::parse($from), CarbonImmutable::parse($to));

        /** @var BalanceOverTime $balances */
        $balances = $bus->dispatch($query);

        if($balances->isEmpty()) {
            error('There is no entries in your balance');
            return self::INVALID;
        }

        $from = $balances->first()->datetime->startOfDay();
        $to = $balances->last()->datetime->endOfDay();

        $balances = $balances->groupByDate($this->xAxisGranularity($from, $to));

        $yScale = $this->yScale($balances->min(), $balances->max());
        $xScale = $this->xScale($from, $to);

        $xScale = array_merge(['Amount'], $xScale);

        //Generate empty array matrix

        $rows = [];
        foreach($xScale as $xIndex => $date) {
            foreach($yScale as $yIndex => $amount) {
                if($xIndex === 0) {
                    $rows[$yIndex][0] = '<info>' . round($amount / 100) . '</info>';
                } else {
                    $rows[$yIndex][$xIndex] = '';
                }
            }
        }

        $sumRowYIndex = $yIndex + 1;

        $rows[$sumRowYIndex][0] = '<info>Total</info>';

        /** @var BalanceOnDatetime $balance */
        foreach($balances->toArray() as $timestamp => $balance) {
            //Check the right box in the matrix
            $xIndexToCheck = $this->getPositionOnXAxis($balance->datetime, $xScale);
            $yIndexToCheck = $this->getPositionOnYAxis($balance->amount->toInt(), $yScale);

            $rows[$yIndexToCheck][$xIndexToCheck] = '<error>x</error>';

            $rows[$sumRowYIndex][$xIndexToCheck] = '<info>' . $balance->amount->toHumanFloat() . '</info>';
        }

        $this->customTable($xScale, $rows);

        return self::SUCCESS;
    }

    private function yScale(int $min, int $max): array
    {
        $minPower = pow(10, strlen(abs($min)) - 1);
        $min = round($min / $minPower, 2) * $minPower;

        $maxPower = pow(10, strlen(abs($max)) - 1);
        $max = round($max / $maxPower, 2) * $maxPower;

        $step = 10 ** floor(log10(abs($min)));
        $result = [];

        for ($i = $max; $i >= $min; $i -= $step) {
            $result[] = $i;
        }

        $result[] = 0;

        $result[] = $i;

        rsort($result, SORT_NUMERIC);

        return $result;
    }

    private function xAxisGranularity(CarbonImmutable $from, CarbonImmutable $to): string
    {
        $diffInDays = $from->diffInDays($to);
        if($diffInDays <= 30) {
            return 'week';
        } else {
            return 'month';
        }
    }

    private function xScale(CarbonImmutable $from, CarbonImmutable $to): array
    {
        //Month from first to last except if duration is below one month, then by weeks.
        $xScale = [];
        $granularityType = $this->xAxisGranularity($from, $to);

        $fromCopy = $from->copy();

        $fromCopy = match($granularityType) {
            'month' => $fromCopy->startOfMonth(),
            'week' => $fromCopy->startOfWeek()
        };

        while ($fromCopy->lt($to)) {
            $xScale[] = $fromCopy->toDateString();

            $fromCopy = match($granularityType) {
                'month' => $fromCopy->addMonth(),
                'week' => $fromCopy->addWeek()
            };
        }

        return $xScale;
    }

    private function getPositionOnXAxis(CarbonImmutable $datetime, array $xScale): int
    {
        foreach($xScale as $index => $date) {
            if($date !== 'Amount') {
                $dateCarboned = CarbonImmutable::parse($date);

                if ($datetime->lt($dateCarboned)) {
                    return max($index -1, 1);
                }
            }
        }

        return 1;
    }

    private function getPositionOnYAxis(int $amount, array $yScale): int
    {
        foreach($yScale as $index => $yAmount) {
            if($amount >= $yAmount) {
                return $index;
            }
        }

        return 0;
    }

    private function customTable(array $xScale, array $rows)
    {
        $table = new Table($this->output);

        $table->setHeaders($xScale);

        $separator = new TableSeparator();

        $lastIndex = count($rows) - 1;
        array_splice($rows, $lastIndex, 0, [$separator]);

        $table->setRows($rows);

        $table->render();
    }
}
