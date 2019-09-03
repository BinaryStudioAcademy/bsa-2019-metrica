<?php


namespace App\Actions\PageTimings;

use App\Utils\DatePeriod;

final class GetServerResponseChartAction extends GetAbstractPageTimingChartAction
{
    protected function getData(DatePeriod $datePeriod, string $period): array
    {
        return $this->repository->getAvgServerResponseByDateRange($datePeriod, $period);
    }
}

