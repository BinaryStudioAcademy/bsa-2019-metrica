<?php

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

interface ChartSessionRepository
{
    public function getSessionByInterval(
        DatePeriod $filter,
        Collection $visitorsId
    ): Collection;
}
