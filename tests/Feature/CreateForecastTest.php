<?php

namespace Tests\Feature;

use Module\Expense\Domain\Objects\CountryCode;
use Module\Forecast\Application\CreateExpenseForecastCommand;
use Module\Forecast\Application\CreateIncomeForecastCommand;
use Module\Forecast\Domain\ForecastRepository;
use Module\Forecast\Infrastructure\Repository\ForecastFactory;
use Module\Forecast\Infrastructure\Repository\ForecastRepositoryDatabase;
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
        $this->forecastRepository = new ForecastRepositoryDatabase(new ForecastFactory());
    }

    public function testItRecordForecastedExpense()
    {
        $cmd = new CreateExpenseForecastCommand(500, VatRate::rate21()->value(), $this->clock->now(), Category::CAR->value, CountryCode::BE->value);
        $this->bus->dispatch($cmd);

        $expenses = $this->forecastRepository->expenseForecastedForYear($this->clock->now()->startOfYear());

        $this->assertCount(1, $expenses);
    }

    public function testItRecordForecastedIncome()
    {
        $cmd = new CreateIncomeForecastCommand(500, VatRate::intracom()->value(), $this->clock->now());
        $this->bus->dispatch($cmd);

        $incomes = $this->forecastRepository->incomeForecastedForYear($this->clock->now()->startOfYear());

        $this->assertCount(1, $incomes);
    }
}
