<?php

namespace Module\Billing\Domain;

use Module\Billing\Domain\Objects\Reference;

interface BillRepository
{
    public function byReference(Reference $reference): Bill;

    public function save(Bill $bill): void;
}
