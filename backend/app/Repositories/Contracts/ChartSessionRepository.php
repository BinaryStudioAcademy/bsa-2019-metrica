<?php

namespace App\Repositories\Contracts;

use App\Model\Sessions\AverageSessionByIntervalFilterData;
use Illuminate\Support\Collection;

interface ChartSessionRepository
{
    public function getAverageSessionByInterval(
        AverageSessionByIntervalFilterData $filter,
        Collection $visitorsId
    ): array;
}
