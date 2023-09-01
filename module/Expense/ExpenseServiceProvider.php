<?php

namespace Module\Expense;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Module\Expense\Application\CreateExpenseCommand;
use Module\Expense\Application\CreateExpenseCommandHandler;
use Module\Expense\Domain\ExpenseRepository;
use Module\Expense\Infrastructure\Repository\ExpenseRepositoryDatabase;

class ExpenseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ExpenseRepository::class, ExpenseRepositoryDatabase::class);
    }

    public function boot()
    {
        Bus::map([
            CreateExpenseCommand::class => CreateExpenseCommandHandler::class,
        ]);
    }
}
