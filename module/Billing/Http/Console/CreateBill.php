<?php

namespace Module\Billing\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Billing\Application\CreateBillCommand;
use Module\Billing\Domain\Objects\TaxRate;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;

class CreateBill extends Command
{
    protected $signature = 'bill:create';

    protected $description = 'Register an emitted bill';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $reference = $this->ask('Enter the Reference');
        $client = $this->askWithCompletion('Enter the client', $this->existingClient());
        $amount = (float) $this->ask('Enter the amount (without tax)');
        $taxRate = (int) $this->choice('Choose the tax rate', TaxRate::values(), TaxRate::rate21()->taxRatePercentage, 5);
        $billingDate = $this->ask('Enter the billing date', $clock->now()->toIso8601String());

        $command = new CreateBillCommand(
            $reference,
            $client,
            $amount,
            $taxRate,
            CarbonImmutable::parse($billingDate),
        );

        $bus->dispatch($command);

        $this->output->success('Done!');

        return self::SUCCESS;
    }

    private function existingClient(): array
    {
        return EloquentBill::query()
            ->select('client')
            ->distinct('client')
            ->get()
            ->pluck('client')
            ->toArray();
    }
}
