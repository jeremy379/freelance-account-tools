<?php

namespace Module\Expense\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Domain\Objects\TaxRate;
use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Domain\Objects\CategoryValue;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;

class CreateExpense extends Command
{
    protected $signature = 'expense:create';

    protected $description = 'Register a paid expense';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $reference = $this->ask('Enter the Reference');
        $category = $this->choice('Choose the category', $this->mapCase(CategoryValue::cases()));
        $provider = $this->askWithCompletion('Enter the provider', $this->existingProvider());
        $amount = (float) $this->ask('Enter the amount (without tax)');
        $taxRate = (int) $this->choice('Choose the tax rate', TaxRate::values(), TaxRate::rate21()->taxRatePercentage, 5);
        $paymentDate = $this->ask('Enter the payment date', $clock->now()->toIso8601String());
        $countryCode = $this->choice('Choose the country', $this->mapCase(CountryCode::cases()));

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

        $this->output->success('Done!');

        return self::SUCCESS;
    }

    private function existingProvider(): array
    {
        return EloquentExpense::query()
            ->select('provider')
            ->distinct('provider')
            ->get()
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
