<?php

namespace Tests\Feature;

use Module\Forecast\Application\CreateForecastCommand;
use Module\Forecast\Domain\ForecastRepository;
use Module\SharedKernel\Domain\Bus;
use Module\SharedKernel\Domain\Category;
use Module\SharedKernel\Domain\ClockInterface;
use Module\SharedKernel\Domain\VatRate;
use Module\SharedKernel\Infrastructure\LaravelBus;
use Tests\FakeClock;
use Tests\TestCase;

class CreateForecastTest extends TestCase
{
    private Bus $bus;
    private ForecastRepository $forecastRepository;
    private ClockInterface $clock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bus = new LaravelBus();
        $this->clock = new FakeClock();
    }

    public function testItRecordForecastedExpense()
    {
        $cmd = new CreateForecastCommand(-500, VatRate::rate21()->taxRatePercentage, $this->clock->now(), Category::CAR->value);
        $this->bus->dispatch($cmd);

        $expenses = $this->forecastRepository->expenseForecastedForYear($this->clock->now()->startOfYear());

        $this->assertEquals(500, $expenses->total());
    }

    public function testItRecordForecastedIncome()
    {
        $cmd = new CreateForecastCommand(500, VatRate::intracom()->taxRatePercentage, $this->clock->now());
        $this->bus->dispatch($cmd);

        $incomes = $this->forecastRepository->incomeForecastedForYear($this->clock->now()->startOfYear());

        $this->assertEquals(500, $incomes->total());
    }
}
