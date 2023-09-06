<?php

namespace Module\Forecast\Domain\Objects;

enum ForecastType: string
{
    case EXPENSE = 'EXPENSE';
    case INCOME = 'INCOME';
}
