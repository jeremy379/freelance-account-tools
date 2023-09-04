<?php

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\Reporting\Application\GetBalanceOnDatetimeQuery;
use Module\Reporting\Application\GetBalanceOverPeriodQuery;
use Module\Reporting\Domain\BalanceOnDatetime;
use Module\Reporting\Domain\BalanceOverTime;
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
                'amount' => -50051,
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

        $this->assertEquals(-40000, $balance->amount->toInt());
    }

    public function testItShowsBalanceOnAllPivotDateBetweenValues()
    {

        /*
         *  M-3     M-3+2S    M-2        M-1          Now
         *  -8000
         *          +8000                               500
         *                     -1000       -1000        -1000
         *  -115               -115         -115        -115
         */

        $this->givenAnExpenseOf(8000 * 100, $this->clock->now()->subMonths(3));
        $this->givenAnExpenseOf(1000 * 100, $this->clock->now()->subMonths(2));
        $this->givenAnExpenseOf(1000 * 100, $this->clock->now()->subMonths(1));
        $this->givenAnExpenseOf(1000 * 100, $this->clock->now());
        $this->givenAnExpenseOf(115 * 100, $this->clock->now()->subMonths(3));
        $this->givenAnExpenseOf(115 * 100, $this->clock->now()->subMonths(2));
        $this->givenAnExpenseOf(115 * 100, $this->clock->now()->subMonths(1));
        $this->givenAnExpenseOf(115 * 100, $this->clock->now());

        $this->givenAnIncomeOf(8000 * 100, $this->clock->now()->subMonths(2)->subWeek());
        $this->givenAnIncomeOf(500 * 100, $this->clock->now());

        $m3 = -8115 * 100;
        $m2s = $m3 + (8000*100);
        $m2 = $m2s + (-1115 * 100);
        $m1 = $m2 + (-1115 * 100);
        $now = $m1 + ((-1115 + 500) *100);

        $expected = [
            $this->clock->now()->subMonths(3)->timestamp => $m3,
            $this->clock->now()->subMonths(2)->subWeek()->timestamp => $m2s,
            $this->clock->now()->subMonths(2)->timestamp => $m2,
            $this->clock->now()->subMonths(1)->timestamp => $m1,
            $this->clock->now()->timestamp => $now
        ];

        $query = new GetBalanceOverPeriodQuery($this->clock->now()->subYear(), $this->clock->now());

        /** @var BalanceOverTime $balance */
        $balances = $this->bus->dispatch($query);

        $this->assertCount(5, $balances);

        /** @var array<BalanceOnDatetime> $balancesArray */
        $balancesArray = $balances->toArray();

        foreach($balancesArray as $balance) {
            $this->assertEquals($expected[$balance->datetime->timestamp], $balance->amount->toInt());
        }
    }

    private function givenAnExpenseOf(int $amount, CarbonImmutable $on)
    {
        EloquentBalanceTransaction::factory(
            [
                'type' => BalanceType::EXPENSE,
                'amount' => -1 * $amount,
                'occurred_on' => $on
            ]
        )->create();
    }

    private function givenAnIncomeOf(int $amount, CarbonImmutable $on)
    {
        EloquentBalanceTransaction::factory(
            [
                'type' => BalanceType::BILL,
                'amount' => $amount,
                'occurred_on' => $on
            ]
        )->create();
    }
}
