<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;

interface ChartSessionsRepository
{
    public function findByFilter(DatePeriod $filterData, int $websiteId): Collection;
}