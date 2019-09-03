<?php


namespace App\Actions\PageTimings;

use App\Utils\DatePeriod;

final class GetDomainLookupChartAction extends GetAbstractPageTimingChartAction
{
    protected function getData(DatePeriod $datePeriod, string $period): array
    {
        return $this->repository->getAvgDomainLookupByDateRange($datePeriod, $period);
    }
}

