<?php

namespace Module\Expense\Domain\Objects;

enum CountryCode: string
{
    case BE = 'BE';
    case FR = 'FR';
    case NL = 'NL';
    case OUTSIDE_EU = 'OUTSIDE_EU';
    case OTHER_EU = 'OTHER_EU';
}
