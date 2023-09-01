<?php

namespace Module\Expense\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EloquentExpense extends Model
{
    protected $table = 'expense';

    protected $fillable = [
        'reference', 'category', 'provider', 'amount', 'tax_rate', 'country_code',
    ];

    public $timestamps = true;
}
