<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\PageViews;

use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;

interface ChartDataRepository
{
    public function getChartAvgTimeOnPageBetweenDate(DatePeriod $filterData, int $interval, int $websiteId): Collection;
}
