<?php

namespace Module\Reporting\Application;

use Module\SharedKernel\Domain\Query;

class GetYearlyOverviewQuery implements Query
{
    public function __construct(public readonly int $year)
    {
    }
}
