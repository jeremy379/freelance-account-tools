<?php

namespace Module\Billing\Domain;

use Carbon\CarbonImmutable;
use Module\Billing\Domain\Objects\Reference;

interface BillRepository
{
    public function byReference(Reference $reference, bool $withPayment = false): Bill|BillWithPayments;

    /**
     * @return array<Bill>
     */
    public function fetchBetween(CarbonImmutable $from, CarbonImmutable $to): array;

    public function save(Bill $bill): void;
}
