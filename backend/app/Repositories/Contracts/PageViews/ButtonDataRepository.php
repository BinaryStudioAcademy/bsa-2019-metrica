<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\PageViews;

use App\Contracts\Common\DatePeriod;

interface ButtonDataRepository
{
    public function countBetweenDate(DatePeriod $filterData, int $websiteId): int;

    public function uniqueCount(DatePeriod $period, int $websiteId): int;
}
