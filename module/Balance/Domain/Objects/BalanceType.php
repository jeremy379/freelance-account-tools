<?php

namespace Module\Balance\Domain\Objects;

enum BalanceType: string
{
    case EXPENSE = 'expense';
    case BILL = 'bill';
}
