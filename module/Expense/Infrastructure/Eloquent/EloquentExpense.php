<?php

namespace Module\Expense\Infrastructure\Eloquent;

use Factory\ExpenseFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentExpense extends Model
{
    protected $table = 'expense';

    protected $fillable = [
        'reference', 'category', 'provider', 'amount', 'tax_rate', 'country_code',
    ];

    public $timestamps = true;

    protected static function newFactory(): ExpenseFactory
    {
        return ExpenseFactory::new();
    }
}
