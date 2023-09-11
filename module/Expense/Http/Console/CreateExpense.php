<?php

namespace Module\Expense\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Domain\VatRate;

use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class CreateExpense extends Command
{
    protected $signature = 'expense:create';

    protected $description = 'Register a paid expense';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $reference = text('Enter the Reference', '051-Provider-title');
        $category = select(label: 'Choose the category', options: $this->mapCase(Category::cases()), scroll: 8);
        $provider = suggest('Enter the provider', $this->existingProvider());
        $amount = (float) text('Enter the amount (without tax)');
        $taxRate = (int) select('Choose the tax rate', VatRate::values(), VatRate::rate21()->value(), 5);
        $paymentDate = text('Enter the payment date', $clock->now()->toIso8601String(), $clock->now()->toDateString());
        $countryCode = select('Choose the country', $this->mapCase(CountryCode::cases()));

        $command = new CreateExpenseCommand(
            $reference,
            $category,
            $provider,
            $amount,
            $taxRate,
            $countryCode,
            CarbonImmutable::parse($paymentDate)
        );

        $bus->dispatch($command);

        info('Done!');

        return self::SUCCESS;
    }

    private function existingProvider(): array
    {
        return EloquentExpense::query()
            ->select('provider')
            ->distinct('provider')
            ->get()
            ->pluck('provider')
            ->toArray();
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
