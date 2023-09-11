<?php

namespace Module\Reporting\Infrastructure\Repository;

use Carbon\CarbonImmutable;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;
use Module\Billing\Infrastructure\BillingFacade;
use Module\Expense\Infrastructure\ExpenseFacade;
use Module\Forecast\Infrastructure\ForecastFacade;
use Module\Reporting\Domain\Config\SocialContributionConfig;
use Module\Reporting\Domain\Config\TaxConfig;
use Module\Reporting\Domain\ReportingRepository;
use Module\Reporting\Domain\SocialContributionCalculator;
use Module\Reporting\Domain\TaxCalculator;

class ReportingRepositoryDatabase implements ReportingRepository
{
    public function __construct(
        private readonly BillingFacade $billingFacade,
        private readonly ExpenseFacade $expenseFacade,
        private readonly ForecastFacade $forecastFacade,
    ) {
    }

    public function balanceBetween(CarbonImmutable $from, CarbonImmutable $to): array
    {
        return EloquentBalanceTransaction::query()
            ->where('occurred_on', '<=', $to)
            ->orderBy('occurred_on')
            ->get()
            ->toArray();
    }

    public function retrieveYearlyOverview(int $year): array
    {
        $billingOverview = $this->billingFacade->getYearlyBill($year);
        $expenseOverview = $this->expenseFacade->getComputedYearlyExpense($year);

        $taxCalculator = new TaxCalculator(TaxConfig::loadConfiguration($year, config('calculator.tax')));
        $socialContributionCalculator = new SocialContributionCalculator(
            SocialContributionConfig::loadConfiguration($year, config('calculator.social_cotisation'))
        );

        $totalIncome = $billingOverview['total'];
        $totalDeductibleExpense = $expenseOverview['totalDeductibleExpense'];
        $netTaxableIncome = $totalIncome - $totalDeductibleExpense;

        $socialContribution = $socialContributionCalculator->compute($netTaxableIncome);

        $taxableIncome = $netTaxableIncome - $socialContribution['yearly_amount'];

        $tax = $taxCalculator->compute(
            $taxableIncome,
            config('calculator.company_zip_code')
        );

        return [
            'bill' => $billingOverview,
            'expense' => $expenseOverview,
            'socialContribution' => $socialContribution,
            'taxable_income' => $taxableIncome,
            'tax' => $tax,
        ];
    }

    public function retrieveYearlyForecastedOverview(int $year, bool $onlyFuture): array
    {
        $realOverview = $this->retrieveYearlyOverview($year);

        $forecastExpenses = $this->forecastFacade->getExpensesForecasted($year, $onlyFuture);
        $forecastIncome = $this->forecastFacade->getIncomeForecasted($year, $onlyFuture);

        $taxCalculator = new TaxCalculator(TaxConfig::loadConfiguration($year, config('calculator.tax')));
        $socialContributionCalculator = new SocialContributionCalculator(
            SocialContributionConfig::loadConfiguration($year, config('calculator.social_cotisation'))
        );

        $totalIncome = $forecastIncome['total'];
        $totalDeductibleExpense = $forecastExpenses['totalDeductibleExpense'];
        $netTaxableIncome = $totalIncome - $totalDeductibleExpense;

        $socialContribution = $socialContributionCalculator->compute($netTaxableIncome);

        $taxableIncome = $netTaxableIncome - $socialContribution['yearly_amount'];

        $tax = $taxCalculator->compute(
            $taxableIncome,
            config('calculator.company_zip_code')
        );

        return [
            'bill' => $forecastIncome,
            'expense' => $forecastExpenses,
            'socialContribution' => $socialContribution,
            'taxable_income' => $taxableIncome,
            'tax' => $tax,
            'real_overview' => $realOverview,
        ];
    }
}
