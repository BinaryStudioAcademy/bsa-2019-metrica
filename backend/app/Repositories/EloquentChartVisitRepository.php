<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Visits\ChartVisit;
use App\Repositories\Contracts\ChartVisitRepository;
use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartVisitRepository implements ChartVisitRepository
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

    public function findByFilter(DatePeriod $filterData, int $interval, int $websiteId): Collection
    {
        $subQuery = "SELECT v.*, (" . $this->roundDate('v.created_at', $interval) . ") as date " .
            "FROM visits AS v LEFT JOIN pages AS p ON p.id = v.page_id WHERE p.website_id = " . "$websiteId " .
            "AND " . $this->toTimestamp('v.created_at') . " >= :start_date" .
            " AND " .
            $this->toTimestamp('v.created_at') . " <= :end_date";

        $query = DB::raw("SELECT COUNT(*) as visits, date FROM ($subQuery) AS periods GROUP BY date");

        $result = DB::select((string)$query, [
            'start_date' => $filterData->getStartDate()->getTimestamp(),
            'end_date' => $filterData->getEndDate()->getTimestamp(),
        ]);

        return collect($result)->map(function ($item) {
            return new ChartVisit($item->date, $item->visits);
        });
    }

    public function getBouncedVisitsCountByTimeFrame(DatePeriod $datePeriod, int $interval, int $websiteId): array
    {
        $subQueryFirst = "SELECT id FROM pages WHERE website_id = :website_id";
        $subQuerySecond = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQueryThird = "SELECT page_id, session_id, start_session FROM ($subQuerySecond) AS visits " .
            "WHERE visits.start_session > :startDate AND visits.start_session < :endDate AND page_id IN ($subQueryFirst)";
        $subQueryForth = "SELECT group_visits.page_id, group_visits.start_session, COUNT(*) " .
            "FROM ($subQueryThird) AS group_visits GROUP BY group_visits.page_id, group_visits.start_session";
        $subQueryFifth = "SELECT group_visits.count, (" . $this->roundDate('group_visits.start_session', $interval) .
            ") AS period FROM ($subQueryForth) AS group_visits";
        $query = DB::raw("SELECT COUNT(*), period FROM ($subQueryFifth) AS periods WHERE count < 2 GROUP BY period");
        $response = DB::select((string)$query, [
            'startDate' => $datePeriod->getStartDate(),
            'endDate' => $datePeriod->getEndDate(),
            'website_id' => $websiteId
        ]);

        return array_column($response, 'count', 'period');
    }

    public function getVisitsCountByTimeFrame(DatePeriod $datePeriod, int $interval, int $websiteId): array
    {
        $subQueryFirst = "SELECT id FROM pages WHERE website_id = :website_id";
        $subQuerySecond = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQueryThird = "SELECT page_id, session_id, start_session FROM ($subQuerySecond) AS visits " .
            "WHERE visits.start_session > :startDate AND visits.start_session < :endDate AND page_id IN ($subQueryFirst)";
        $subQueryForth = "SELECT group_visits.*, (" . $this->roundDate('group_visits.start_session', $interval) .
            ") AS period FROM ($subQueryThird) AS group_visits";
        $query = DB::raw("SELECT COUNT(*), period FROM ($subQueryForth) AS periods GROUP BY period;");
        $response = DB::select((string)$query, [
            'startDate' => $datePeriod->getStartDate(),
            'endDate' => $datePeriod->getEndDate(),
            'website_id' => $websiteId
        ]);

        return array_column($response, 'count', 'period');
    }

    public function getUniquePageViews(DatePeriod $datePeriod, int $interval, int $websiteId): Collection
    {
        $subQuery = " SELECT COUNT(p.id) as page_id,
                    (" . $this->roundDate('v.visit_time', $interval) . " ) as period
                         FROM \"sessions\" s
                     INNER JOIN \"visits\" v ON s.id=v.session_id
                     INNER JOIN \"pages\" p ON v.page_id=p.id  
                          WHERE s.website_id=:website_id AND (v.visit_time BETWEEN :startDate AND :endDate)
                       GROUP BY s.id,p.id,period";
        $query = DB::raw("SELECT COUNT(page_id) as count,period
             FROM($subQuery) as periods GROUP BY period");
        $result = DB::select((string)$query, [
            'startDate' => $datePeriod->getStartDate(),
            'endDate' => $datePeriod->getEndDate(),
            'website_id' => $websiteId
        ]);
        return collect($result)->map(function ($item) {
            return new ChartVisit($item->period, $item->count);
        });
    }
}
