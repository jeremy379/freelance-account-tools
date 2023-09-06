<?php

namespace Module\Reporting\Http\Console;

use Illuminate\Console\Command;
use Module\Reporting\Application\GetYearlyOverviewQuery;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;

class YearlyOverview extends Command
{
    protected $signature = 'overview';

    protected $description = 'Print the yearly overview';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $year = $this->ask('Which year result do you want to print?', $clock->now()->year);

        $query = new GetYearlyOverviewQuery($year);
        $result = $bus->dispatch($query);



        dd($result);


        return self::SUCCESS;
    }
}
