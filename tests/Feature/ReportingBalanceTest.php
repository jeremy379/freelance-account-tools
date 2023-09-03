<?php

namespace Tests\Feature;

use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\Reporting\Application\GetBalanceOnDatetimeQuery;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Infrastructure\LaravelBus;
use Tests\FakeClock;
use Tests\TestCase;

class ReportingBalanceTest extends TestCase
{
    private ClockInterface $clock;
    private Bus $bus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clock = new FakeClock();
        $this->bus = new LaravelBus();
    }

    public function testItShowsBalanceOnDatetime()
    {
        EloquentBalanceTransaction::factory(
            [
                'type' => BalanceType::EXPENSE,
                'amount' => 50051,
                'occurred_on' => $this->clock->now()->subHour()
            ]
        )->create();

        EloquentBalanceTransaction::factory(
            [
                'type' => BalanceType::BILL,
                'amount' => 10051,
                'occurred_on' => $this->clock->now()
            ]
        )->create();

        $query = new GetBalanceOnDatetimeQuery($this->clock->now()->addDay());

        /** @var BalanceOnDatetime $balance */
        $balance = $this->bus->dispatch($query);

        $this->assertEquals(40000, $balance->amount->toInt());
    }

    public function testItShowsBalanceOnAllPivotDateBetweenValues()
    {
        //Given Expenses
        //Given Bill
        // Return array with pivot date and value
    }
}
