<?php

namespace Module\Billing\Domain;

use Carbon\CarbonImmutable;
use Module\Billing\Domain\Events\BillPaid;
use Module\Billing\Domain\Objects\Amount;
use Module\Billing\Domain\Objects\Client;
use Module\Billing\Domain\Objects\Reference;
use Module\SharedKernel\Domain\VatRate;
use Module\SharedKernel\Domain\DomainEntityWithEvents;
use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\SavingMode;

class Bill implements DomainEntityWithEvents
{
    private array $events = [];
    private SavingMode $savingMode;

    private function __construct(
        public readonly Reference       $reference,
        public readonly Client          $client,
        public readonly Amount          $amountWithoutTax,
        public readonly VatRate         $taxRate,
        public readonly CarbonImmutable $billingDate,
    ) {
    }

    public static function record(
        Reference       $reference,
        Client          $client,
        Amount          $amountWithoutTax,
        VatRate         $taxRate,
        CarbonImmutable $billingDate,
    ): Bill {
        $bill = new self(
            $reference,
            $client,
            $amountWithoutTax,
            $taxRate,
            $billingDate,
        );
        $bill->savingMode = SavingMode::CREATE;

        return $bill;
    }

    public static function restore(
        Reference       $reference,
        Client          $client,
        Amount          $amountWithoutTax,
        VatRate         $taxRate,
        CarbonImmutable $billingDate,
    ): Bill {
        return new self(
            $reference,
            $client,
            $amountWithoutTax,
            $taxRate,
            $billingDate,
        );
    }

    public function paymentReceived(CarbonImmutable $receivedOn, Amount $amountReceived): Bill
    {
        $bill = $this->copy();

        $bill->chainEvent(new BillPaid($bill->reference->value, $amountReceived->toInt(), $receivedOn));

        return $bill;
    }

    public function chainEvent(DomainEvent $domainEvent): void
    {
        $this->events[] = $domainEvent;
    }

    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    public function savingMode(): SavingMode
    {
        return $this->savingMode ?? SavingMode::NONE;
    }

    private function copy(): Bill
    {
        $bill = new self(
            $this->reference,
            $this->client,
            $this->amountWithoutTax,
            $this->taxRate,
            $this->billingDate,
        );

        $bill->savingMode = $this->savingMode();

        return $bill;
    }
}
