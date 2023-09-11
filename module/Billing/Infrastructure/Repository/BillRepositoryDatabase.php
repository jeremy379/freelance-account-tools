<?php

namespace Module\Billing\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Module\Billing\Domain\Bill;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Domain\BillWithPayments;
use Module\Billing\Domain\Exception\BillNotFound;
use Module\Billing\Domain\Objects\Reference;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\SharedKernel\Domain\SavingMode;

class BillRepositoryDatabase implements BillRepository
{
    public function __construct(private readonly BillDomainFactory $factory)
    {
    }

    public function save(Bill $bill): void
    {
        if($bill->savingMode() === SavingMode::CREATE) {
            EloquentBill::create([
                'reference' => $bill->reference->value,
                'client' => $bill->client->value,
                'amount' => $bill->amountWithoutTax->toInt(),
                'tax_rate' => $bill->taxRate->value(),
                'billing_datetime' => $bill->billingDate,
            ]);
        }
    }

    public function byReference(Reference $reference, bool $withPayment = false): Bill|BillWithPayments
    {
        $dbBill = EloquentBill::where('reference', $reference->value)->first();

        if($dbBill === null) {
            throw BillNotFound::byReference($reference->value);
        }

        if($withPayment) {
            return $this->factory->toBillWithPayment($dbBill);
        } else {
            return $this->factory->toBill($dbBill);
        }

    }

    public function fetchBetween(CarbonImmutable $from, CarbonImmutable $to): array
    {
        return EloquentBill::query()
            ->where(function (Builder $query) use ($from, $to) {
                $query->where('billing_datetime', '>=', $from);

                if($to) {
                    $query->where('billing_datetime', '<=', $to);
                }
            })
            ->get()
            ->transform(fn (EloquentBill $bill) => $this->factory->toBill($bill))
            ->toArray()
        ;
    }
}
