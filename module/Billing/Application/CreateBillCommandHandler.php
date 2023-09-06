<?php

namespace Module\Billing\Application;

use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\Exception\BillNotFound;
use Module\Billing\Domain\Exception\CannotCreateBill;
use Module\Billing\Domain\Objects\Amount;
use Module\Billing\Domain\Objects\Client;
use Module\Billing\Domain\Objects\Reference;
use Module\SharedKernel\Domain\VatRate;

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
                     0, 'exempt' => VatRate::exempt(),
                     'intracom' => VatRate::intraCom(),
                     6 => VatRate::rate6(),
                     20 => VatRate::rate20(),
                     21 => VatRate::rate21(),
                     default => VatRate::exempt()
                 },
                 $command->billingDate,
             );

             $this->billRepository->save($bill);
         }
    }
}
