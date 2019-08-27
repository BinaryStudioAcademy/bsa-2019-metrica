<?php

declare(strict_types=1);

namespace App\Repositories\PageViews;

use App\Contracts\Common\DatePeriod;
use App\Entities\Visit;
use App\Repositories\Contracts\PageViews\ChartDataRepository;
use Illuminate\Support\Facades\DB;
use App\DataTransformer\ChartValue;
use Illuminate\Support\Collection;


class EloquentChartDataRepository implements ChartDataRepository
{
    public function getChartAvgTimeOnPageBetweenDate(
        DatePeriod $filterData, int $websiteId): Collection
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

        $visitsGrpoupedBySessionAndVisitDaySubQuery = "(SELECT p.id, $visitDayColumn as visit_day, $avgVisitTimeColumn
                                            FROM $sessionsAndVisitsSubQuery
                                            GROUP BY $visitDayColumn, p.id) AS chart";

        $sql = "SELECT chart.visit_day, AVG(chart.avg_by_session) as avg_time
                              FROM $visitsGrpoupedBySessionAndVisitDaySubQuery
                              GROUP BY chart.visit_day";

        $chartData = DB::select($sql, $bindings);

        return collect($chartData)->map(function($item){
            return new ChartValue($item->visit_day, $item->avg_time);
        });
    }
}
