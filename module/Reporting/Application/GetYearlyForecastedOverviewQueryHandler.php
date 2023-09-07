<?php

namespace Module\Reporting\Application;

use Module\Reporting\Domain\ReportingRepository;

class GetYearlyForecastedOverviewQueryHandler
{
    public function __construct(private ReportingRepository $repository)
    {

    }

    public function handle(GetYearlyForecastedOverviewQuery $query): array
    {
        return $this->repository->retrieveYearlyForecastedOverview($query->year, $query->onlyFuture);
    }
}
