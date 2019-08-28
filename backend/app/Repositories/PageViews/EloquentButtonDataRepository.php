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

        $visitDayColumn = "date_trunc('day', p.visit_time)";

        $visitsGrpoupedBySessionSubQuery = "(SELECT p.id, $visitDayColumn as visit_day, $avgVisitTimeColumn
                                            FROM $sessionsAndVisitsSubQuery
                                            GROUP BY $visitDayColumn, p.id) AS grouped";

        $sql = "SELECT AVG(grouped.avg_by_session) AS avg_time
                              FROM $visitsGrpoupedBySessionSubQuery";

        $avgTime = DB::select($sql, $bindings)[0]->avg_time;

        return (int)$avgTime;
    }
}
