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

        //As it's only future, the month from jan. to current need to be added to the forecast

        //dd($result);

        $table = new Table($this->output);

        $table->setHeaderTitle('Combined Results for ' . $year);
        $table->setHorizontal();
        $table->setHeaders(['', 'Income', 'Expense', 'Inc. deductible', 'Net taxable', 'Social contribution', 'Taxable', 'Tax', 'Vat to pay', 'Vat to get back']);

        $table->setRows([
            [
                '<info>Based on current value</info>',
                $result['real_overview']['bill']['total'] .' €',
                $result['real_overview']['expense']['totalExpense'] .' €',
                $result['real_overview']['expense']['totalDeductibleExpense'] .' €',
                $result['real_overview']['bill']['total'] - $result['expense']['totalDeductibleExpense'] .' €',
                $result['real_overview']['socialContribution']['yearly_amount'] .' €',
                $result['real_overview']['taxable_income'] .' €',
                '<error>' . $result['real_overview']['tax'] . ' €</error>',
                $result['real_overview']['bill']['totalVatCollected'] .' €',
                $result['real_overview']['expense']['vatToRecover'] .' €',
            ],
            [
                '<info>Based on projection</info>',
                $result['real_overview']['bill']['total'] + $result['bill']['total'] .' €',
                $result['real_overview']['expense']['totalExpense'] + $result['expense']['totalExpense'] .' €',
                $result['real_overview']['expense']['totalDeductibleExpense'] + $result['expense']['totalDeductibleExpense'] .' €',
                $result['real_overview']['bill']['total'] + $result['bill']['total'] - $result['expense']['totalDeductibleExpense'] - $result['expense']['totalDeductibleExpense'] .' €',
                $result['real_overview']['socialContribution']['yearly_amount'] + $result['socialContribution']['yearly_amount'] .' €',
                $result['real_overview']['taxable_income'] + $result['taxable_income'] .' €',
                '<error>' . $result['real_overview']['tax'] + $result['tax'] . ' €</error>',
                $result['real_overview']['bill']['totalVatCollected'] + $result['bill']['totalVatCollected'] .' €',
                $result['real_overview']['expense']['vatToRecover'] + $result['expense']['vatToRecover'] .' €',
            ],
        ]);

        $table->render();

        return self::SUCCESS;
    }
}
