<?php

namespace Module\Balance\Infrastructure\Eloquent;

use Factory\BalanceFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentBalance extends Model
{
    protected $table = 'balance';

    protected $fillable = [
        'type', 'reference', 'amount', 'occurred_on',
    ];

    public $timestamps = true;

    protected static function newFactory(): BalanceFactory
    {
        return BalanceFactory::new();
    }
}
