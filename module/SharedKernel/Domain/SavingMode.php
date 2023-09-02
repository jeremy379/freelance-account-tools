<?php

namespace Module\SharedKernel\Domain;

enum SavingMode
{
    case CREATE;
    case UPDATE;
    case DELETE;
    case NONE;
}
