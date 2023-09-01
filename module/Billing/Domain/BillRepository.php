<?php

namespace Module\Billing\Domain;

interface BillRepository
{
    public function save(Bill $bill): void;
}
