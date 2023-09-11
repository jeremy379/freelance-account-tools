<?php

namespace Module\Billing\Application;

use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Objects\Amount;
use Module\Billing\Domain\Objects\Reference;
use Module\SharedKernel\Domain\EventDispatcher;

class ReceiveBillPaymentCommandHandler
{
    public function __construct(private BillRepository $billRepository, private EventDispatcher $eventDispatcher)
    {
    }

    public function handle(ReceiveBillPaymentCommand $command): void
    {
        $bill = $this->billRepository->byReference(Reference::fromString($command->reference));

        $bill = $bill->paymentReceived($command->paymentReceivedOn, Amount::fromFloat($command->amountReceivedIncludingTaxes));

        $this->eventDispatcher->dispatch(...$bill->popEvents());
    }
}
