<?php

namespace Module\Balance\Infrastructure\Eloquent;

use Factory\BalanceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentBalanceTransaction extends Model
{
    use HasFactory;

    protected $table = 'balance_transaction';

    protected $fillable = [
        'type', 'reference', 'amount', 'occurred_on',
    ];

    public $timestamps = true;

    protected static function newFactory(): BalanceFactory
    {
        return BalanceFactory::new();
    }
}
