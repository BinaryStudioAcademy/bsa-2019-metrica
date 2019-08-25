<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Contracts\Common\DatePeriod;

interface ButtonDataPageViews
{
    public function countBetweenDate(DatePeriod $filterData, int $websiteId): int;
    public function getAvgTimeOnPageBetweenDate(DatePeriod $filterData, int $websiteId): int;
}
