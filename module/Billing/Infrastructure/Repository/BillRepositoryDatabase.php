<?php

namespace Module\Billing\Infrastructure\Repository;

use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Objects\Reference;

class BillRepositoryDatabase implements BillRepository
{
    public function save(Bill $bill): void
    {
        // TODO: Implement save() method.
    }

    public function byReference(Reference $reference): Bill
    {
        // TODO: Implement byReference() method.
    }
}
