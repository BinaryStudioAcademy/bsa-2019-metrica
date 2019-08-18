<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Sessions\ChartSessions;
use App\Repositories\Contracts\ChartSessionsRepository;
use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartSessionsRepository implements ChartSessionsRepository
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
        $subQuery = "SELECT s.*, (" . $this->roundDate('s.created_at', $interval) . ") as date " .
            "FROM sessions AS s WHERE s.website_id = " . "$websiteId ".
            "AND " . $this->toTimestamp('s.created_at') . " >= :start_date" .
            " AND " .
            $this->toTimestamp('s.created_at') . " <= :end_date";

        $query = DB::raw("SELECT COUNT(*) as sessions, date FROM ($subQuery) AS periods GROUP BY date");

        $result =  DB::select((string)$query, [
            'start_date' => $filterData->getStartDate()->getTimestamp(),
            'end_date' =>  $filterData->getEndDate()->getTimestamp(),
        ]);

        return collect($result)->map(function ($item) {
            return new ChartSessions($item->date, $item->visits);
        });
    }
}
