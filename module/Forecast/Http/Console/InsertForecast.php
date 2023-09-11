<?php

namespace Module\Forecast\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Billing\Application\CreateBillCommand;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Forecast\Application\CreateExpenseForecastCommand;
use Module\Forecast\Application\CreateIncomeForecastCommand;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Domain\VatRate;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class InsertForecast extends Command
{
    protected $signature = 'forecast:create';

    protected $description = 'Insert a forecast expense or bill';

    public function handle(ClockInterface $clock, Bus $bus): int
    {
        $billOrExpense = select('What forecast do you want to add?', ['Income', 'Expense']);

        $amount = (float) text(label: 'Enter the amount', validate: fn (string $value) => match(true) {
            !is_numeric($value) => 'The amount must be a number',
            empty($value) && $value !== 0 => 'The amount is required',
            default => null,
        });

        $vatRate = select('Which vat rate applies to this forecast', VatRate::values());


        $forecastedOnDates = [];
        if($this->confirm('Is it a recurrent forecast (each month for one full year')) {
            $day = text('Day of month');
            $year = text('Repeat each month of year');

            for($i = 1; $i <= 12; $i++) {
                $forecastedOnDates[] = CarbonImmutable::now()->setYear($year)->setMonth($i)->setDay($day);
            }
        } else {
            $forecastedOn = text(label: 'Forecasted On', default: $clock->now()->toDateString());
            $forecastedOnDates[] = CarbonImmutable::parse($forecastedOn);
        }

        if($billOrExpense === 'Expense') {
            $category = select('Which category of expense does it belongs?', $this->mapCase(Category::cases()));
            $countryCode = select('In Which country this expense belongs? (for VAT)', $this->mapCase(CountryCode::cases()));

            foreach($forecastedOnDates as $forecastedOn) {
                $command = new CreateExpenseForecastCommand(
                    $amount,
                    $vatRate,
                    $forecastedOn,
                    $category,
                    $countryCode,
                );

                $bus->dispatch($command);
            }

        } else {
            foreach($forecastedOnDates as $forecastedOn) {
                $command = new CreateIncomeForecastCommand(
                    $amount,
                    $vatRate,
                    $forecastedOn
                );
                $bus->dispatch($command);
            }
        }

        info('Done !');

        return self::SUCCESS;
    }

    /**
     * @param array<\BackedEnum> $cases
     */
    private function mapCase(array $cases): array
    {
        $response = [];
        foreach($cases as $case) {
            $response[$case->name] = $case->value;
        }

        return $response;
    }
}
