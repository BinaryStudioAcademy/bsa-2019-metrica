<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;

interface ChartVisitRepository
{
    public function findByFilter(DatePeriod $filterData, int $interval, int $websiteId): Collection;
}
