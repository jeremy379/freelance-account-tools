<?php

namespace Module\Billing\Infrastructure\Eloquent;

use Factory\BillFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Module\Balance\Infrastructure\Eloquent\EloquentBalanceTransaction;

class EloquentBill extends Model
{
    use HasFactory;

    protected $table = 'bill';

    protected $fillable = [
        'reference', 'client', 'amount', 'tax_rate', 'billing_datetime',
    ];

    public $timestamps = true;

    public function payments(): HasMany
    {
        return $this->hasMany(EloquentBalanceTransaction::class, 'reference', 'reference');
    }

    protected static function newFactory(): BillFactory
    {
        return BillFactory::new();
    }
}
