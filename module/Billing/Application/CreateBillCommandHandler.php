<?php

namespace Module\Billing\Application;

use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Exception\BillNotFound;
use Module\Billing\Domain\Exception\CannotCreateBill;
use Module\Billing\Domain\Objects\Amount;
use Module\Billing\Domain\Objects\Client;
use Module\Billing\Domain\Objects\Reference;
use Module\Billing\Domain\Objects\TaxRate;

class CreateBillCommandHandler
{
    public function __construct(private BillRepository $billRepository)
    {
    }

    public function handle(CreateBillCommand $command): void
    {
         try {
             $this->billRepository->byReference(Reference::fromString($command->reference));
             throw CannotCreateBill::referenceAlreadyExists($command->reference);
         }  catch (BillNotFound) {
             $bill = Bill::record(
                 Reference::fromString($command->reference),
                 Client::fromString($command->client),
                 Amount::fromFloat($command->amountWithoutTax),
                 match($command->taxRate) {
                     0, 'exempt' => TaxRate::exempt(),
                     'intracom' => TaxRate::intraCom(),
                     6 => TaxRate::rate6(),
                     20 => TaxRate::rate20(),
                     21 => TaxRate::rate21(),
                     default => TaxRate::exempt()
                 },
                 $command->billingDate,
             );

             $this->billRepository->save($bill);
         }
    }
}
