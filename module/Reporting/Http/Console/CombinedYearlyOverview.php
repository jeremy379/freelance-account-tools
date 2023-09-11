<?php

namespace Module\Reporting\Http\Console;

use Illuminate\Console\Command;
use Module\Reporting\Application\GetYearlyForecastedOverviewQuery;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;
use Symfony\Component\Console\Helper\Table;

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

        $table = new Table($this->output);

        $table->setHeaderTitle('Combined Results for ' . $year);
        $table->setHorizontal();
        $table->setHeaders(['', 'Income', 'Expense', 'Inc. deductible', 'Net taxable', 'Social contribution', 'Taxable', 'Tax', 'Net left', 'Vat to pay', 'Vat to get back']);

        $realOverview = $result['real_overview'];
        $realNetTaxable = round($realOverview['bill']['total'] - $realOverview['expense']['totalDeductibleExpense'], 2);
        $totalNetLeft = $realOverview['taxable_income'] - $realOverview['tax'];

        $table->setRows([
            [
                '<info>Based on current value</info>',
                $realOverview['bill']['total'] .' €',
                $realOverview['expense']['totalExpense'] .' €',
                round($realOverview['expense']['totalDeductibleExpense'], 2) .' €',
                $realNetTaxable .' €',
                $realOverview['socialContribution']['yearly_amount'] .' € (Incl. ' . $realOverview['socialContributionAlreadyPaid'] . '€ already paid)',
                round($realOverview['taxable_income'], 2) .' €',
                '<error>' . $realOverview['tax'] . ' €</error> (Incl. ' . $realOverview['taxProvisioned'] . '€ already provisioned)',
                round($totalNetLeft, 2) . '€ (' .  round($totalNetLeft/ 12, 2) .'€/month)',
                $realOverview['bill']['totalVatCollected'] .' €',
                $realOverview['expense']['vatToRecover'] .' €',
            ],
            [
                '<info>Based on projection</info>',
                $realOverview['bill']['total'] + $result['bill']['total'] .' €',
                $realOverview['expense']['totalExpense'] + $result['expense']['totalExpense'] .' €',
                round($realOverview['expense']['totalDeductibleExpense'] + $result['expense']['totalDeductibleExpense'], 2) .' €',
                $realNetTaxable + $result['bill']['total'] - $result['expense']['totalDeductibleExpense'] .' €',
                $realOverview['socialContribution']['yearly_amount'] + $result['socialContribution']['yearly_amount'] .' €',
                round($realOverview['taxable_income'] + $result['taxable_income'], 2) .' €',
                '<error>' . $realOverview['tax'] + $result['tax'] . ' €</error>',
                $realOverview['taxable_income'] + $result['taxable_income'] - $realOverview['tax'] - $result['tax'] .
                    '€ (' . round(($realOverview['taxable_income'] + $result['taxable_income'] - $realOverview['tax'] - $result['tax']) / 12, 2) .'€/month)',
                $realOverview['bill']['totalVatCollected'] + $result['bill']['totalVatCollected'] .' €',
                $realOverview['expense']['vatToRecover'] + $result['expense']['vatToRecover'] .' €',
            ],
        ]);

        $table->render();

        return self::SUCCESS;
    }
}
