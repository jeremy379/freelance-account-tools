<?php

namespace Module\Expense\Domain\Config;

use Module\Expense\Domain\Objects\CountryCode;
use Module\SharedKernel\Domain\Category;
use Webmozart\Assert\Assert;

class DeductibilityConfiguration
{
    private function __construct(private array $categoriesDeductibility, private array $vatHandledForCountries)
    {
    }

    public static function loadConfiguration(array $configuration): DeductibilityConfiguration
    {
        Assert::keyExists($configuration, 'category');
        Assert::keyExists($configuration, 'vat_handle_for_countries');

        return new self($configuration['category'], $configuration['vat_handle_for_countries']);
    }

    public function deductibilityRateFor(Category $categoryValue): float
    {
        return $this->categoriesDeductibility[$categoryValue->value] / 100;
    }

    public function isVATCanBeRefundIn(CountryCode $countryCode): bool
    {
        return in_array($countryCode->value, $this->vatHandledForCountries);
    }
}
