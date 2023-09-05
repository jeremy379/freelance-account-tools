<?php

namespace Tests\Unit;

use Module\Reporting\Domain\Config\SocialContributionConfig;
use Module\Reporting\Domain\SocialContributionCalculator;
use Tests\TestCase;

class SocialContributionCalculatorTest extends TestCase
{
    private SocialContributionConfig $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = SocialContributionConfig::loadConfiguration(2023, [
            2023 => [
                'slices' => [
                    [
                        'from' => 0,
                        'to' => 70857.99,
                        'rate' => 20.5,
                    ],
                    [
                        'from' => 70858,
                        'to' => 104422.24,
                        'rate' => 14.16,
                    ],
                ],
                'final_slice' => [
                    'from' => 104422.25,
                    'fixed_amount' => 4819.65 * 4
                ],
                'managing_fees_rate' => 4.25,
            ]
        ]);
    }

    /**
     * @dataProvider exampleIncome
     */
    public function testItComputeSocialContribution(float $income, float $expectedValue)
    {
        $calculator = new SocialContributionCalculator($this->config);

        $calculator = $calculator->compute($income);

        $this->assertEquals([
            'yearly_amount' => $expectedValue,
            'periodic_amount' => $this->commercialRound(( ($expectedValue*100) / 4) /100, 2),
            'period' => 'P3M',
        ], $calculator);
    }

    public static function exampleIncome(): array
    {
        return [
            [
                60000,
                12822.75
            ],
            [
                80000,
                16492.76
            ],
            [
                115000,
                20097.94
            ],
        ];
    }

    private function commercialRound(float $number, int $precision = 0): float {
        $factor = 10 ** $precision;
        $rounded = round($number * $factor);
        return $rounded / $factor;
    }
}
