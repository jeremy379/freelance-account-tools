<?php

namespace Module\Billing;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Billing\Application\CreateBillCommand;
use Module\Billing\Application\CreateBillCommandHandler;
use Module\Billing\Application\GetBillWithPaymentByReferenceHandler;
use Module\Billing\Application\GetBillWithPaymentByReferenceQuery;
use Module\Billing\Application\ReceiveBillPaymentCommand;
use Module\Billing\Application\ReceiveBillPaymentCommandHandler;
use Module\Billing\Domain\BillRepository;
use Module\Billing\Infrastructure\Repository\BillRepositoryDatabase;

class BillingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BillRepository::class, BillRepositoryDatabase::class);
    }

    public function boot()
    {
        Bus::map([
            CreateBillCommand::class => CreateBillCommandHandler::class,
            ReceiveBillPaymentCommand::class => ReceiveBillPaymentCommandHandler::class,
            GetBillWithPaymentByReferenceQuery::class => GetBillWithPaymentByReferenceHandler::class,
        ]);
    }
}
