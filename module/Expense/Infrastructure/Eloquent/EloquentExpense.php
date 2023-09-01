<?php

namespace Module\Expense\Infrastructure\Eloquent;

use Factory\ExpenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;

class EloquentExpense extends Model
{
    use HasFactory;

    protected $table = 'expense';

    protected $fillable = [
        'reference', 'category', 'provider', 'amount', 'tax_rate', 'country_code',
    ];

    public $timestamps = true;

    protected static function newFactory(): ExpenseFactory
    {
        return ExpenseFactory::new();
    }

    public function payment(): HasOne
    {
        return $this->hasOne(EloquentBalanceTransaction::class, 'reference', 'reference');
    }
}
