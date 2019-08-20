<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Common\DatePeriod;
use App\Entities\Visit;
use App\Repositories\Contracts\ButtonDataPageViews;

class EloquentButtonDataPageViews implements ButtonDataPageViews
{
    public function countBetweenDate(DatePeriod $filterData, int $websiteId): int
    {
        return Visit::has('pages')->with(['pages' => function($query) use($websiteId)
        {
            $query->where('website_id', '=', $websiteId);
        }])
            ->whereBetween('visit_time', [$filterData->getStartDate(), $filterData->getEndDate()])
            ->count();
    }
}
