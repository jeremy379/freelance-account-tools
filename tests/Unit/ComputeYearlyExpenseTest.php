<?php

namespace Tests\Unit;

use Module\Balance\Domain\Objects\BalanceType;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Billing\Domain\Objects\TaxRate;
use Module\Expense\Domain\Config\DeductibilityConfiguration;
use Module\Expense\Domain\Objects\CategoryValue;
use Module\Expense\Domain\Objects\CountryCode;
use Module\Expense\Infrastructure\Eloquent\EloquentExpense;
use Module\Expense\Domain\ComputeYearlyExpense;
use Module\Expense\Infrastructure\Repository\ExpenseDomainFactory;
use Module\Expense\Infrastructure\Repository\ExpenseRepositoryDatabase;
use Module\SharedKernel\Domain\ClockInterface;
use Tests\FakeClock;
use Tests\TestCase;

class ComputeYearlyExpenseTest extends TestCase
{
    private DeductibilityConfiguration $configuration;
    private ClockInterface $clock;

    protected function setUp(): void
    {
        $config = [
            'category' => [
                CategoryValue::CAR->value => 30, // Percentage of pro usage.
                CategoryValue::CAR->value => 100,
                CategoryValue::ACCOUNTANT->value => 100,
                CategoryValue::TRAVEL->value => 100,
                CategoryValue::SOCIAL_CHARGE->value => 100,
                CategoryValue::TAX_PREVISION->value => 0,
                CategoryValue::TAX->value => 100,
                CategoryValue::TVA_PAYMENT->value => 0,
                CategoryValue::HARDWARE->value => 100,
                CategoryValue::SOFTWARE->value => 100,
                CategoryValue::SERVICES->value => 100,
                CategoryValue::OTHERS->value => 100,
                CategoryValue::OTHERS_NOT_DEDUCTIBLE->value => 0,
                CategoryValue::HOUSE_EXPENSE->value => 7.64, //Area of office
            ],
            'vat_handle_for_countries' => ['BE'], //To be able to get TVA refund, your accountant need to make a procedure in each country. This mostly depend on the amount of VAT you have to get back in that country.
        ];
        parent::setUp();

        $this->configuration = DeductibilityConfiguration::loadConfiguration($config);
        $this->clock = new FakeClock();
    }

    public function testItComputeExpenses()
    {
        $carExpense = $this->givenExpense(CategoryValue::CAR, 880.50, TaxRate::rate21(), CountryCode::BE);
        $travelExpense = $this->givenExpense(CategoryValue::TRAVEL, 250.50, TaxRate::rate20(), CountryCode::FR);
        $houseExpense = $this->givenExpense(CategoryValue::HOUSE_EXPENSE, 4000, TaxRate::rate6(), CountryCode::BE);
        $accountantExpense = $this->givenExpense(CategoryValue::ACCOUNTANT, 115, TaxRate::rate21(), CountryCode::BE);

        $totalExpenses = 4;
        $totalAmount = 880.50 + 250.50 + 4000 + 115;
        $deductible = (100 * 880.50 * 0.3)
            + (100 * 250.50 * 1.20 * 1) // Expense where tva cannot be deducted should be counted with TVA included
            + (100 * 4000 * 0.0764)
            + (100 * 115 * 1);
        $deductible /= 100;


        $calculator = new ComputeYearlyExpense(
            new ExpenseRepositoryDatabase(
                new ExpenseDomainFactory()
            ),
            $this->configuration
        );

        $result = $calculator->compute($year = $this->clock->now()->year);

        $this->assertEquals($totalExpenses, $result->expenseCount);
        $this->assertEquals($totalAmount, $result->totalExpense);
        $this->assertEquals($deductible, $result->totalDeductibleExpense);
        $this->assertEquals($year, $result->year);
    }

    private function givenExpense(CategoryValue $categoryValue, float $amount, TaxRate $taxRate, CountryCode $countryCode): EloquentExpense
    {
        $amount *= 100;//We store int.

        $expense = EloquentExpense::factory(
            [
                'category' => $categoryValue->value,
                'amount' => $amount,
                'tax_rate' => $taxRate->taxRatePercentage,
                'country_code' => $countryCode->value,
            ]
        )->create();

        EloquentBalanceTransaction::factory()->create([
            'type' => BalanceType::EXPENSE,
            'reference' => $expense->reference,
            'amount' => $expense->amount,
            'occurred_on' => (new FakeClock())->now()->startOfYear()->addDays(random_int(1, 360)),
        ]);

        return $expense;
    }
}
