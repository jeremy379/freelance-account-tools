<?php

namespace Module\SharedKernel\Infrastructure;

use Illuminate\Support\Facades\Validator;

trait CommandValidator
{
    protected array $rules = [
        'expense.reference' => 'required|string|unique:expense,reference',
        'bill.reference' => 'required|string|unique:bill,reference',
    ];

    private function validate(string $field, $value): ?string
    {

        $ruleToApply = [$field => $this->rules[$field]];

        $validator = Validator::make([$field => $value], $ruleToApply);

        return $validator->fails() ? implode(',', $validator->errors()->all()) : null;
    }
}
