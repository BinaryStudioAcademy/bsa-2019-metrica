<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Contracts\Visits\PageViewsFilterData;
use App\DataTransformer\DataTransformerInterface;

interface ChartVisitRepository
{
    public function findByFilter(PageViewsFilterData $filterData, int $interval): DataTransformerInterface;
}
