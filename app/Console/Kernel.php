<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Module\Billing\Http\Console\BillPaymentReceived;
use Module\Billing\Http\Console\CreateBill;
use Module\Expense\Http\Console\CreateExpense;
use Module\Reporting\Http\Console\GetBalanceOverTime;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateBill::class,
        BillPaymentReceived::class,
        CreateExpense::class,
        GetBalanceOverTime::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
