<?php

namespace Module\SharedKernel\Domain;

enum Category: string
{
    case CAR = 'CAR';
    case ACCOUNTANT = 'ACCOUNTANT';
    case TRAVEL = 'TRAVEL';
    case SOCIAL_CHARGE = 'SOCIAL_CHARGE';
    case TAX_PREVISION = 'TAX_PREVISION';
    case TAX = 'TAX';
    case TVA_PAYMENT = 'TVA_PAYMENT';
    case HARDWARE = 'HARDWARE';
    case SOFTWARE = 'SOFTWARE';
    case SERVICES = 'SERVICES';
    case OTHERS = 'OTHERS';
    case OTHERS_NOT_DEDUCTIBLE = 'OTHERS_NOT_DEDUCTIBLE';
    case HOUSE_EXPENSE = 'HOUSE_EXPENSE';
    case PLCI = 'PLCI';
    case INSURANCE = 'INSURANCE';
}
