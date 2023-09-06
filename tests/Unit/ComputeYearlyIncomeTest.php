<?php

namespace Tests\Unit;

use Module\Billing\Domain\ComputeYearlyIncome;
use Module\SharedKernel\Domain\VatRate;
use Module\Billing\Infrastructure\Eloquent\EloquentBill;
use Module\Billing\Infrastructure\Repository\BillDomainFactory;
use Module\Billing\Infrastructure\Repository\BillRepositoryDatabase;
use Module\SharedKernel\Domain\ClockInterface;
use Tests\FakeClock;
use Tests\TestCase;

class ComputeYearlyIncomeTest extends TestCase
{
    private ClockInterface $clock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clock = new FakeClock();
    }

    public function testItComputeIncome()
    {
        $this->givenBill(7850, VatRate::intraCom());
        $this->givenBill(5000, VatRate::intraCom());
        $this->givenBill(10800, VatRate::intraCom());
        $this->givenBill(2500, VatRate::rate21());
        $this->givenBill(125, VatRate::rate21());

        $computer = new ComputeYearlyIncome(
            new BillRepositoryDatabase(new BillDomainFactory())
        );

        $result = $computer->compute($year =$this->clock->now()->year);

        $this->assertEquals(5, $result->billCount);
        $this->assertEquals($year, $result->year);
        $this->assertEquals(7850 + 5000 +10800 +2500 +125, $result->total);
        $this->assertEquals((2500 + 125) * 0.21 , $result->totalVatCollected);
    }

    private function givenBill(float $amount, VatRate $taxRate) {
        EloquentBill::factory()->create([
            'amount' => $amount * 100,
            'tax_rate' => $taxRate->taxRatePercentage,
            'billing_datetime' => $this->clock->now()->startOfYear()->addDays(random_int(1, 360)),
        ]);
    }
}
