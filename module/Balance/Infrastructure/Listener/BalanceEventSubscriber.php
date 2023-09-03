<?php

namespace Module\Balance\Infrastructure\Listener;

use Carbon\CarbonImmutable;
use Illuminate\Events\Dispatcher;
use Module\Balance\Domain\Balance;
use Module\Balance\Domain\BalanceRepository;
use Module\Balance\Domain\Objects\Amount;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Domain\Objects\Reference;
use Module\Billing\Domain\Events\BillPaid;
use Module\Expense\Domain\Events\ExpensePaid;
use Module\SharedKernel\Domain\EventDispatcher;

class BalanceEventSubscriber
{
    private BalanceRepository $balanceRepository;
    private EventDispatcher $eventDispatcher;

    public function __construct()
    {
        $this->balanceRepository = resolve(BalanceRepository::class);
        $this->eventDispatcher = resolve(EventDispatcher::class);
    }

    public function handleBillPaid(string $reference, int $amount, string $occurredOn)
    {
        $balance = Balance::newEntry(
            Amount::fromStoredInt($amount),
            BalanceType::BILL,
            Reference::fromString($reference),
            CarbonImmutable::parse($occurredOn),
        );
        $this->balanceRepository->save($balance);
        $this->eventDispatcher->dispatch(...$balance->popEvents());
    }

    public function handleExpensePaid(string $reference, int $amount, string $occurredOn)
    {
        $balance = Balance::newEntry(
            Amount::fromStoredInt($amount),
            BalanceType::EXPENSE,
            Reference::fromString($reference),
            CarbonImmutable::parse($occurredOn),
        );
        $this->balanceRepository->save($balance);
        $this->eventDispatcher->dispatch(...$balance->popEvents());
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            BillPaid::NAME,
            [self::class, 'handleBillPaid']
        );

        $dispatcher->listen(
            ExpensePaid::NAME,
            [self::class, 'handleExpensePaid']
        );

    }
}
