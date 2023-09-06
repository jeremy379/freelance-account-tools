<?php

namespace Module\Reporting\Application;

use Module\Reporting\Domain\ReportingRepository;

class GetYearlyOverviewQueryHandler
{
    public function __construct(private ReportingRepository $repository)
    {

    }

    public function handle(GetYearlyOverviewQuery $query): array
    {
        $overview = $this->repository->retrieveYearlyOverview($query->year);

        return $overview;
    }
}
