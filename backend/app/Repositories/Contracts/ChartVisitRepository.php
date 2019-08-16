<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Contracts\Visits\PageViewsFilterData;
use Illuminate\Support\Collection;

interface ChartVisitRepository
{
    public function findByFilter(PageViewsFilterData $filterData, int $interval): Collection;
}
