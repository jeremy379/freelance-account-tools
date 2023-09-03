<?php

namespace Module\Billing\Http\Console;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Module\Billing\Application\GetBillWithPaymentByReferenceQuery;
use Module\Billing\Application\ReceiveBillPaymentCommand;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;

class BillPaymentReceived extends Command
{
    protected $signature = 'bill:payment-received';

    protected $description = 'Record a payment for a specific bill';

    public function handle(Bus $bus, ClockInterface $clock): int
    {
        $reference = $this->ask('Enter the bill reference');
        $amountReceived = $this->ask('Enter the amount received');
        $receptionDatetime = $this->ask('Enter the date of reception of the amount', $clock->now()->toIso8601String());

        $command = new ReceiveBillPaymentCommand($reference, $amountReceived, CarbonImmutable::parse($receptionDatetime));

        $bus->dispatch($command);

        $this->output->success('Amount credited !');

        return self::SUCCESS;
    }
}
