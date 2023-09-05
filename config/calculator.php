<?php

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
];
