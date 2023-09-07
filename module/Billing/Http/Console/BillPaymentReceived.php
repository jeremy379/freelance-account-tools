<?php

namespace Module\Billing\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Module\Billing\Application\GetBillWithPaymentByReferenceQuery;
use Module\Billing\Application\ReceiveBillPaymentCommand;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\text;

class BillPaymentReceived extends Command
{
    protected $signature = 'bill:payment-received';

    protected $description = 'Record a payment for a specific bill';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $reference = suggest('Enter the bill reference', $this->billReferenceWithLeftToPay());
        $amountReceived = text('Enter the amount received');
        $receptionDatetime = text('Enter the date of reception of the amount', $clock->now()->toIso8601String());

        $command = new ReceiveBillPaymentCommand($reference, $amountReceived, CarbonImmutable::parse($receptionDatetime));

        $bus->dispatch($command);

        $this->output->success('Amount credited !');

        return self::SUCCESS;
    }

    private function billReferenceWithLeftToPay(): array
    {
        return EloquentBill::query()
            ->whereDoesntHave('payments')
            ->pluck('reference')
            ->toArray();
    }
}
