<?php

declare(strict_types=1);

namespace App\Repositories\PageViews;

use App\Contracts\Common\DatePeriod;
use App\Entities\Visit;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use Illuminate\Support\Facades\DB;

class EloquentButtonDataRepository implements ButtonDataRepository
{
    public function countBetweenDate(DatePeriod $filterData, int $websiteId): int
    {
        return Visit::whereHas('page', function($query) use ($websiteId) {
            $query->where('website_id', '=', $websiteId);
        })
            ->whereBetween('visit_time', [$filterData->getStartDate(), $filterData->getEndDate()])
            ->count();
    }

    public function getAvgTimeOnPageBetweenDate(DatePeriod $filterData, int $websiteId): int
    {
        $bindings = [
            $websiteId,
            $filterData->getStartDate(),
            $filterData->getEndDate()
        ];

        $sessionsAndVisitsSubQuery = '(SELECT s.id, v.visit_time, s.start_session
                                        FROM sessions s
                                        JOIN visits v ON v.session_id = s.id
                                        JOIN websites w ON w.id = s.website_id
                                        WHERE s.website_id = ?
                                              AND
                                              v.visit_time BETWEEN ? AND ?
                                      ) AS p';

        $avgVisitTimeColumn = 'EXTRACT(EPOCH FROM (MAX(p.visit_time) - MIN(p.visit_time))) / COUNT(p.id) as avg_by_session';

        $visitsGrpoupedBySessionSubQuery = "(SELECT p.id, $avgVisitTimeColumn
                                            FROM $sessionsAndVisitsSubQuery
                                            GROUP BY p.id) AS grouped";

        $sql = "SELECT AVG(grouped.avg_by_session) AS avg_time
                              FROM $visitsGrpoupedBySessionSubQuery";

        $avgTime = DB::select($sql, $bindings)[0]->avg_time;

        return (int)$avgTime;
    }
}
