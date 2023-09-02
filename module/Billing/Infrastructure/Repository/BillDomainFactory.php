<?php

namespace Module\Billing\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillWithPayments;
use Module\Billing\Domain\Objects\Amount;
use Module\Billing\Domain\Objects\BillPayment;
use Module\Billing\Domain\Objects\Client;
use Module\Billing\Domain\Objects\Reference;
use Module\Billing\Domain\Objects\TaxRate;
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
                0, 'exempt' => TaxRate::exempt(),
                'intracom' => TaxRate::intraCom(),
                6 => TaxRate::rate6(),
                20 => TaxRate::rate20(),
                21 => TaxRate::rate21(),
                default => TaxRate::exempt()
            },
            CarbonImmutable::parse($bill->billing_datetime)
        );
    }

    public function toBillWithPayment(EloquentBill $bill): ExpenseWithPayment
    {
        $billObject = $this->toBill($bill);

        $billWithPayment = BillWithPayments::bill($billObject);

        foreach($bill->payments as $payment) {
            $billWithPayment = $billWithPayment->withPayment(BillPayment::with($payment->occurred_on, Amount::fromStoredInt($payment->amount)));
        }
    }
}
