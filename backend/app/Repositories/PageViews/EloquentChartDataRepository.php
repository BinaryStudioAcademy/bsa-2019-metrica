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
    private function toTimestamp(string $columnName): string
    {
        return "extract(epoch FROM $columnName)";
    }

    private function toInteger(string $expression): string
    {
        return "(CAST ($expression AS INTEGER))";
    }

    private function roundDate(string $columnName, float $period): string
    {
        return
            $this->toTimestamp($columnName) .
            " - MOD(" . $this->toInteger($this->toTimestamp($columnName)) . " , " . $period . ")";
    }


    public function getChartAvgTimeOnPageBetweenDate(
        DatePeriod $filterData, int $interval, int $websiteId): Collection
    {
        $bindings = [
            $websiteId,
            $filterData->getStartDate(),
            $filterData->getEndDate()
        ];

        $sessionsAndVisitsSubQuery = "(SELECT s.id, v.visit_time, s.start_session,
                                        (" . $this->roundDate('v.visit_time', $interval) . " ) as period
                                        FROM sessions s
                                        JOIN visits v ON v.session_id = s.id
                                        JOIN websites w ON w.id = s.website_id
                                        WHERE s.website_id = ?
                                              AND
                                              v.visit_time BETWEEN ? AND ?
                                      ) AS p";

        $avgVisitTimeColumn = 'EXTRACT(EPOCH FROM (MAX(p.visit_time) - MIN(p.visit_time))) / COUNT(p.id) as avg_time';


        $sql = "SELECT $avgVisitTimeColumn , p.period
                              FROM $sessionsAndVisitsSubQuery
                              GROUP BY p.period";

        $chartData = DB::select($sql, $bindings);

        return collect($chartData)->map(function($item) {
            return new ChartValue($item->period, $item->avg_time);
        });
    }
}
