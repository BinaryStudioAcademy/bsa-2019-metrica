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

    public function getCountPageViewsPageBetweenDate(DatePeriod $filterData, int $websiteId): int
    {
        $subQueryFirst = "SELECT id FROM pages WHERE website_id = :website_id";
        $subQuerySecond = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQueryThird = "SELECT page_id, session_id, start_session FROM ($subQuerySecond) AS visits " .
            "WHERE visits.start_session >= :startDate AND visits.start_session <= :endDate AND page_id IN ($subQueryFirst)";
        $query = DB::raw("SELECT COUNT(*) as count FROM ($subQueryThird) AS grouped;");
        $response = DB::select((string)$query, [
            'startDate' => $filterData->getStartDate(),
            'endDate' => $filterData->getEndDate(),
            'website_id' => $websiteId
        ]);

        return $response[0]->count;
    }

    public function getBouncedPagePageBetweenDate(DatePeriod $filterData, int $websiteId): int
    {
        $subQueryFirst = "SELECT id FROM pages WHERE website_id = :website_id";
        $subQuerySecond = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQueryThird = "SELECT page_id, session_id, start_session FROM ($subQuerySecond) AS visits " .
            "WHERE visits.start_session >= :startDate AND visits.start_session <= :endDate AND page_id IN ($subQueryFirst)";
        $subQueryForth = "SELECT COUNT(*), grouped.session_id FROM ($subQueryThird) AS grouped GROUP BY grouped.session_id";
        $query = DB::raw("SELECT COUNT(*) as count FROM ($subQueryForth) AS c WHERE count < 2;");
        $response = DB::select((string)$query, [
            'startDate' => $filterData->getStartDate(),
            'endDate' => $filterData->getEndDate(),
            'website_id' => $websiteId
        ]);

        return $response[0]->count;
    }

    public function getAverageTiming(DatePeriod $period, int $website_id, string $parameter): string
    {
        $average =  Visit::forWebsite($website_id)
            ->whereDateBetween($period)->avg($parameter);
        return $average ?? "0";
    }
}
