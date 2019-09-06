<?php


namespace App\Actions\PageTimings;

use App\Utils\DatePeriod;

final class GetPageLoadingChartAction extends GetAbstractPageTimingChartAction
{
    protected function getData(DatePeriod $datePeriod, string $period, int $websiteId): array
    {
        return $this->repository->getAvgPageLoadByDateRange($datePeriod, $period, $websiteId);
    }
}

