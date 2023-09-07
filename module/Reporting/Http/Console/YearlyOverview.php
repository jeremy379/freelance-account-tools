<?php

namespace Module\Reporting\Http\Console;

use Illuminate\Console\Command;
use Module\Reporting\Application\GetYearlyOverviewQuery;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use function Laravel\Prompts\text;

class YearlyOverview extends Command
{
    protected $signature = 'overview';

    protected $description = 'Print the yearly overview';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $year = text('Which year result do you want to print?', $clock->now()->year, $clock->now()->year);

        $query = new GetYearlyOverviewQuery($year);
        $result = $bus->dispatch($query);

        $table = new Table($this->output);

        $table->setHeaderTitle('Results for year ' . $year);
        $table->setHorizontal();
        $table->setHeaders(['Income', 'Expense', 'Inc. deductible', 'Net taxable', 'Social contribution', 'Taxable', 'Tax', 'Vat to pay', 'Vat to get back']);

        $table->setRows([
            [
                $result['bill']['total'] .' €',
                $result['expense']['totalExpense'] .' €',
                $result['expense']['totalDeductibleExpense'] .' €',
                $result['bill']['total'] - $result['expense']['totalDeductibleExpense'] .' €',
                $result['socialContribution']['yearly_amount'] .' €',
                $result['taxable_income'] .' €',
                '<error>' . $result['tax'] . ' €</error>',
                $result['bill']['totalVatCollected'] .' €',
                $result['expense']['vatToRecover'] .' €',
            ],
        ]);

        $table->render();

        return self::SUCCESS;
    }
}
