<?php

namespace Module\Expense\Domain;

use Carbon\CarbonImmutable;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\Expense\Domain\Objects\Amount;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Domain\Objects\Provider;
use Module\Expense\Domain\Objects\Reference;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\DomainEntityWithEvents;
use Module\SharedKernel\Domain\DomainEvent;
use Module\SharedKernel\Domain\SavingMode;
use Module\SharedKernel\Domain\VatRate;

class Expense implements DomainEntityWithEvents
{
    private array $events = [];
    private SavingMode $savingMode;

    private function __construct(
        public readonly Reference   $reference,
        public readonly Category    $category,
        public readonly Provider    $provider,
        public readonly Amount      $amount,
        public readonly VatRate     $taxRate,
        public readonly CountryCode $countryCode,
    ) {
    }

    public static function record(
        Reference   $reference,
        Category    $category,
        Provider    $provider,
        Amount      $amount,
        VatRate     $taxRate,
        CountryCode $countryCode
    ): Expense {
        $expense =  new self(
            $reference,
            $category,
            $provider,
            $amount,
            $taxRate,
            $countryCode
        );
        $expense->savingMode = SavingMode::CREATE;

        return $expense;
    }

    public function pay(CarbonImmutable $paymentDatetime): Expense
    {
        $expense = $this->copy();

        $expense->chainEvent(new ExpensePaid(
            $expense->reference->value,
            $expense->amount->withTax($this->taxRate)->toInt(),
            $paymentDatetime
        ));

        return $expense;
    }

    public static function restore(
        Reference   $reference,
        Category    $category,
        Provider    $provider,
        Amount      $amount,
        VatRate     $taxRate,
        CountryCode $countryCode
    ): Expense {
        return new self(
            $reference,
            $category,
            $provider,
            $amount,
            $taxRate,
            $countryCode
        );
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

    private function copy(): Expense
    {
        $expense = new self(
            $this->reference,
            $this->category,
            $this->provider,
            $this->amount,
            $this->taxRate,
            $this->countryCode,
        );

        $expense->savingMode = $this->savingMode();
        return $expense;
    }
}
