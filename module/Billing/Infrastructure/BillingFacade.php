<?php

namespace Module\Billing\Infrastructure;

use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\ComputeYearlyIncome;

class BillingFacade
{
    public function __construct(private BillRepository $repository)
    {
    }

    public function getYearlyBill(int $year): array
    {
        $computeService = new ComputeYearlyIncome($this->repository);

        return $computeService->compute($year)->toArray();
    }
}
