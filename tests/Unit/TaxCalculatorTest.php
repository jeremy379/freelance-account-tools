<?php

namespace Tests\Unit;

use Module\Reporting\Domain\Config\TaxConfig;
use Module\Reporting\Domain\TaxCalculator;
use Tests\TestCase;

class TaxCalculatorTest extends TestCase
{
    private TaxConfig $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = TaxConfig::loadConfiguration(2023, [
            2023 => [
                'slices' => [
                    // https://finances.belgium.be/fr/particuliers/declaration_impot/taux-revenus-imposables/taux
                    [
                        'from' => 0,
                        'to' => 15200,
                        'rate' => 25,
                    ],
                    [
                        'from' => 15200,
                        'to' => 26830,
                        'rate' => 40,
                    ],
                    [
                        'from' => 26830,
                        'to' => 46440,
                        'rate' => 45,
                    ],
                ],
                'threshold_after_last_slice' => 46440,
                'rate_after_last_slice' => 50,
                'exoneratedAmount' => 10160,
                'rate_city_tax' => [
                    '5030' => 7.8
                ]
            ]
        ]);
    }

    /**
     * @dataProvider incomesValues
     */
    public function testItComputeTax(float $taxableIncomeAfterAllDeduction, float $expectedTax, array $computationDetails)
    {
        $calculator = new TaxCalculator($this->config);

        $tax = $calculator->compute($taxableIncomeAfterAllDeduction, '5030');

        $this->assertEquals($expectedTax, $tax);

        $this->assertEquals($computationDetails, $calculator->computationDetails());
    }

    public static function incomesValues(): array
    {
        return [
            [
                38198.88,
                14626.30, //13568 * 7.8% (city tax),
                [
                    [
                        'amount' => 15200,
                        'rate' => 25
                    ],
                    [
                        'amount' => 11630,
                        'rate' => 40,
                    ],
                    [
                        'amount' => 11368.88,
                        'rate' => 45
                    ],
                ]
            ],
            [
                83216.66,
                38446.69, //35664.83 * 7,8% city tax,
                [
                    [
                        'amount' => 15200,
                        'rate' => 25
                    ],
                    [
                        'amount' => 11630,
                        'rate' => 40,
                    ],
                    [
                        'amount' => 19610,
                        'rate' => 45
                    ],
                    [
                        'amount' => 36776.66,
                        'rate' => 50
                    ],
                ]
            ]
        ];
    }
}
