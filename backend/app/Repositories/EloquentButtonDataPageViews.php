<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Common\DatePeriod;
use App\Entities\Visit;
use App\Repositories\Contracts\ButtonDataPageViews;
use Illuminate\Support\Facades\DB;

class EloquentButtonDataPageViews implements ButtonDataPageViews
{
    public function countBetweenDate(DatePeriod $filterData, int $websiteId): int
    {
        return Visit::whereHas('page', function ($query) use ($websiteId) {
            $query->where('website_id', '=', $websiteId);
        })
            ->whereBetween('visit_time', [$filterData->getStartDate(), $filterData->getEndDate()])
            ->count();
    }

    public function uniqueCount(DatePeriod $period, int $websiteId): int
    {
        $subQuery = "SELECT s.id as session_id, p.id as page_id
                FROM \"sessions\" s
                    INNER JOIN \"visits\" v ON s.id=v.session_id
                     INNER JOIN \"pages\" p ON v.page_id=p.id
                WHERE s.website_id=:websiteId AND (v.visit_time >=:startDate AND v.visit_time<=:endDate) 
                    GROUP BY s.id, p.id";
        $query = DB::raw("SELECT COUNT(*) as count FROM ($subQuery) as grouped");
        $result = DB::select((string)$query, [
            'startDate' => $period->getStartDate(),
            'endDate' => $period->getEndDate(),
            'websiteId' => $websiteId
        ]);

        return $result[0]->count;
    }
}
