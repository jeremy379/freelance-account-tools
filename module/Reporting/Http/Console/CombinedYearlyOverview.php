<?php

namespace Module\Reporting\Http\Console;

use Illuminate\Console\Command;
use Module\Reporting\Application\GetYearlyForecastedOverviewQuery;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;
use function Laravel\Prompts\text;

class CombinedYearlyOverview extends Command
{
    protected $signature = 'overview:combined';

    protected $description = 'Get a combined overview with real and forecasted value';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $year = text('Which year result do you want to print?', $clock->now()->year, $clock->now()->year);

        $query = new GetYearlyForecastedOverviewQuery($year, true);
        $result = $bus->dispatch($query);

        dd($result);

        return self::SUCCESS;
    }
}
