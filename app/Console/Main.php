<?php

namespace App\Console;

use Illuminate\Console\Command;
use Module\Billing\Http\Console\BillPaymentReceived;
use Module\Billing\Http\Console\CreateBill;
use Module\Expense\Http\Console\CreateExpense;
use Module\Forecast\Http\Console\InsertForecast;
use Module\Reporting\Http\Console\CombinedYearlyOverview;
use Module\Reporting\Http\Console\GetBalanceOverTime;
use Module\Reporting\Http\Console\YearlyForecastedOverview;
use Module\Reporting\Http\Console\YearlyOverview;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\select;

class Main extends Command
{
    protected $signature = 'menu';

    protected $description = 'Display main menu';

    protected array $lists = [
        CreateBill::class,
        CreateExpense::class,
        InsertForecast::class,
        BillPaymentReceived::class,
        GetBalanceOverTime::class,
        YearlyOverview::class,
        YearlyForecastedOverview::class,
        CombinedYearlyOverview::class,
    ];

    public function __invoke()
    {
        intro('This main menu offer you a simple navigation through the option of this tools.');

        $options = [];
        /** @var array<Command> $commandClass */
        $commandClass = [];

        foreach($this->lists as $command)
        {
            $commandClass[$command] = new $command;

            $options[$command] = $commandClass[$command]->getName() . ' (' . $commandClass[$command]->getDescription() . ')';
        }

        $command = $this->commandSelector($options);

        do {

            $this->call($commandClass[$command]->getName());

            $command = $this->commandSelector($options);

        } while(true);
    }

    private function commandSelector(array $options): string
    {
        return select(label: 'Action', options: $options);
    }
}
