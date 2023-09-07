<?php

namespace Module\Forecast\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EloquentForecast extends Model
{
    protected $table = 'forecast';

    protected $fillable = [
        'type', 'category', 'amount', 'vat_rate', 'forecasted_on', 'country_code',
    ];

    public $timestamps = true;
}
