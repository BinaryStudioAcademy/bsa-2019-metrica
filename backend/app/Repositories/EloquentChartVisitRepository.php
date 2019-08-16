<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visits\PageViewsFilterData;
use App\DataTransformer\visits\ChartVisit;
use App\Repositories\Contracts\ChartVisitRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartVisitRepository implements ChartVisitRepository
{
    public function toTimestamp(string $columnName): string
    {
        return "extract(epoch FROM $columnName)";
    }

    public function toInteger(string $expression): string
    {
        return "(CAST ($expression AS INTEGER)";
    }

    public function roundDate(string $columnName, int $period): string
    {
        return
            $this->toTimestamp($columnName) .
            " - MOD(" . $this->toInteger($this->toTimestamp($columnName)) . ") , " . $period . ")";
    }

    public function findByFilter( PageViewsFilterData $filterData, int $interval): Collection
    {
        $subQuery = "SELECT visits.*, (" . $this->roundDate('created_at', $interval) . ") as date " .
            "FROM visits " .
            "WHERE " . $this->toTimestamp('created_at') . " >= :start_date" .
            " AND " .
            $this->toTimestamp('created_at') . " <= :end_date";

        $query = DB::raw("SELECT COUNT(*) as visits, date FROM ($subQuery) AS periods GROUP BY date");

        $result =  DB::select((string)$query, [
            'start_date' => $filterData->getStartDate()->getTimestamp(),
            'end_date' =>  $filterData->getEndDate()->getTimestamp(),
        ]);


        return collect($result)->map(function ($item) {
            return new ChartVisit($item->date, $item->visits);
        });
    }
}
