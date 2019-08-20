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
            $query->on('visits.page_id', '=', 'pages.id')
            ->where('pages.website_id', '=', $websiteId);
        }])
            ->whereBetween('created_at', [$filterData->getStartDate(), $filterData->getEndDate()])
            ->count();
    }
}
