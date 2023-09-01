<?php

namespace Module\Balance\Application;

use Module\Billing\Domain\BillRepository;
use Module\SharedKernel\Domain\Command;

class CreateBillCommandHandler
{
    public function __construct(private BillRepository $billRepository)
    {
    }

    public function handle(CreateBillCommand $command): void
    {

    }
}
