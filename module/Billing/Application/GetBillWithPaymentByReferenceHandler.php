<?php

namespace Module\Billing\Application;

use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\BillWithPayments;
use Module\Billing\Domain\Objects\Reference;
use Module\SharedKernel\Domain\Query;

class GetBillWithPaymentByReferenceHandler implements Query
{
    public function __construct(private BillRepository $billRepository)
    {
    }

    public function handle(GetBillWithPaymentByReferenceQuery $query): BillWithPayments
    {
        return $this->billRepository->byReference(Reference::fromString($query->reference), true);
    }
}
