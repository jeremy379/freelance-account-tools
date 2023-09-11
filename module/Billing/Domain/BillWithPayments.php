<?php

namespace Module\Billing\Domain;

use Module\Billing\Domain\Objects\BillPayment;

class BillWithPayments
{
    /** @param  array<BillPayment>  $billPayments */
    private function __construct(
        public readonly Bill $bill,
        public readonly array $billPayments
    ) {
    }

    public static function bill(Bill $bill): BillWithPayments
    {
        return new self($bill, []);
    }

    public function withPayment(BillPayment $billPayment): BillWithPayments
    {
        return new self($this->bill, array_merge($this->billPayments, $billPayment));
    }

    public function fullyPaid(): bool
    {
        $totalPaid = 0;
        foreach ($this->billPayments as $payment) {
            $totalPaid += $payment->amount->toInt();
        }

        return $totalPaid >= $this->bill->amountWithoutTax->withTax($this->bill->taxRate);
    }
}
