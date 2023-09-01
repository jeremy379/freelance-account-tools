<?php

namespace Module\Balance\Infrastructure\Listener;

use Illuminate\Events\Dispatcher;
use Module\Billing\Domain\Events\BillPaid;
use Module\Expense\Domain\Events\ExpensePaid;

class BalanceEventSubscriber
{
    public function handleBillPaid(string $event, ...$arg)
    {

    }

    public function handleExpensePaid(string $event, ...$arg)
    {

    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            BillPaid::class,
            [self::class, 'handleBillPaid']
        );

        $dispatcher->listen(
            ExpensePaid::class,
            [self::class, 'handleExpensePaid']
        );

    }
}
