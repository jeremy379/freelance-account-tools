<?php

namespace Module\Balance\Application;

use Module\Billing\Domain\BillRepository;
use Module\SharedKernel\Domain\EventDispatcher;

class ReceiveBillPaymentCommandHandler
{
    public function __construct(private BillRepository $billRepository, private EventDispatcher $eventDispatcher)
    {
    }

    public function handle(ReceiveBillPaymentCommand $command): void
    {

    }
}
