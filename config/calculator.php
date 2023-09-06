<?php

use \Module\Expense\Domain\Objects\CategoryValue;
return [
    'social_cotisation' => [
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
                'fixed_amount' => 4819.65 * 4,
            ],
            'managing_fees_rate' => 4.25,
        ],
    ],
    'tax' => [
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
            'rate_city_tax' => [ // https://finances.belgium.be/sites/default/files/downloads/111-taux-taxe-communale-2023.pdf
                '5030' => 7.8
            ]
        ]
    ],
    'deductibility' => [
        'category' => [
            CategoryValue::CAR->value => 30, // Percentage of pro usage.
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
            CategoryValue::PLCI->value => 100,
        ],
      'vat_handle_for_countries' => ['BE'], //To be able to get TVA refund, some stuff need to be requested by your accountant : https://finances.belgium.be/fr/entreprises/tva/international/remboursement-de-la-tva-etrangere/assujettis-etablis-en-belgique#q1
    ],
    'company_zip_code' => env('COMPANY_ZIP_CODE', 5030),
];
