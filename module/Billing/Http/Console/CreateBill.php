<?php

namespace Module\Billing\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Billing\Application\CreateBillCommand;
use Module\SharedKernel\Domain\VatRate;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;

use Module\SharedKernel\Infrastructure\CommandValidator;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\info;

class CreateBill extends Command
{
    use CommandValidator;

    protected $signature = 'bill:create';

    protected $description = 'Register an emitted bill';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $reference = text('Enter the Reference', $clock->now()->year . '-001', validate: fn(string $value) => $this->validate('bill.reference', $value));
        $client = suggest('Enter the client', $this->existingClient());
        $amount = (float) text('Enter the amount (without tax)');
        $taxRate = (int) select('Choose the tax rate', VatRate::values(), VatRate::rate21()->rate());
        $billingDate = text('Enter the billing date', $clock->now()->toDateString(), $clock->now()->toDateString());

        $command = new CreateBillCommand(
            $reference,
            $client,
            $amount,
            $taxRate,
            CarbonImmutable::parse($billingDate),
        );

        $bus->dispatch($command);

        info('Done');

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
