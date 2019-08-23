<?php

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;

interface ButtonVisitorsRepository
{
    public function getVisitorsCount(DatePeriod $period, int $websiteId, int $userId): int;
}
