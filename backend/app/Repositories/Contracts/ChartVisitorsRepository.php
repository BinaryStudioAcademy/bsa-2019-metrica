<?php

namespace App\Repositories\Contracts;

use App\Contracts\Visitors\VisitorsBounceRateFilterData;
use Illuminate\Support\Collection;

interface ChartVisitorsRepository
{
    public function getNewVisitorsByDate(string $startData, string $endData, string $period, int $userId): Collection;

    public function getVisitorsCountByTimeFrame(VisitorsBounceRateFilterData $filterData): array;

    public function getBouncedVisitorsCountByTimeFrame(VisitorsBounceRateFilterData $filterData): array;
}
