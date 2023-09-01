<?php

namespace Module\Billing\Infrastructure\Repository;

use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillRepository;

class BillRepositoryDatabase implements BillRepository
{
    public function save(Bill $bill): void
    {
        // TODO: Implement save() method.
    }
}
