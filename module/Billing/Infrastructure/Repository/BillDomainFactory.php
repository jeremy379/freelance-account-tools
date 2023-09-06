<?php

namespace Module\Billing\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillWithPayments;
use Module\Billing\Domain\Objects\Amount;
use Module\Billing\Domain\Objects\BillPayment;
use Module\Billing\Domain\Objects\Client;
use Module\Billing\Domain\Objects\Reference;
use Module\SharedKernel\Domain\VatRate;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;

class BillDomainFactory
{
    public function toBill(EloquentBill $bill): Bill
    {
        return Bill::restore(
            Reference::fromString($bill->reference),
            Client::fromString($bill->client),
            Amount::fromStoredInt($bill->amount),
            match($bill->tax_rate) {
                0, 'exempt' => VatRate::exempt(),
                'intracom' => VatRate::intraCom(),
                6 => VatRate::rate6(),
                20 => VatRate::rate20(),
                21 => VatRate::rate21(),
                default => VatRate::exempt()
            },
            CarbonImmutable::parse($bill->billing_datetime)
        );
    }

    public function toBillWithPayment(EloquentBill $bill): BillWithPayments
    {
        $billObject = $this->toBill($bill);

        $billWithPayment = BillWithPayments::bill($billObject);

        foreach($bill->payments as $payment) {
            $billWithPayment = $billWithPayment->withPayment(BillPayment::with($payment->occurred_on, Amount::fromStoredInt($payment->amount)));
        }

        return $billWithPayment;
    }
}
