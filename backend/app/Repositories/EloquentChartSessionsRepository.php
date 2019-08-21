<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Sessions\ChartSessions;
use App\Repositories\Contracts\ChartSessionsRepository;
use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Entities\Session;

final class EloquentChartSessionsRepository implements ChartSessionsRepository
{
    private function toTimestamp(string $columnName): string
    {
        return "extract(epoch FROM $columnName)";
    }

//    private function toInteger(string $expression): string
//    {
//        return "(CAST ($expression AS INTEGER))";
//    }
//
//    private function roundDate(string $columnName, float $period): string
//    {
//        return
//            $this->toTimestamp($columnName) .
//            " - MOD(" . $this->toInteger($this->toTimestamp($columnName)) . " , " . $period . ") + $period";
//    }

    public function findByFilter(DatePeriod $filterData, int $websiteId): Collection
    {
//        , (" . $this->roundDate('s.start_session', $interval) . ") as date " .
        $subQuery = "SELECT s.*" .
        "FROM sessions AS s " .
        "WHERE " .
            "s.website_id = " . "$websiteId AND (" .
            $this->toTimestamp('s.start_session') . " >= :start_date AND " .
            $this->toTimestamp('s.start_session') . " <= :end_date) OR (" .
            $this->toTimestamp('s.start_session') . " <= :start_date AND " .
            $this->toTimestamp('s.end_session') . " >= :start_date)";

//        $query = DB::raw("SELECT COUNT(*) as sessions, date FROM ($subQuery) AS periods GROUP BY date");
//        dd($subQuery);
        $result = DB::select((string)$subQuery, [
        'start_date' => $filterData->getStartDate()->getTimestamp(),
        'end_date' => $filterData->getEndDate()->getTimestamp(),
        ]);
//        dd($result);
        return collect($result)->map(function ($item) {
            return array(
                $item->start_session,
                $item->end_session,
                $item->website_id,
            );
        });

//        $result = Session::where('website_id', $websiteId)
//            ->whereDateBetween($filterData)
//            ->get()
//            ->reduce(function ($hashTable, $item) use ($interval) {
//                $startTimestamp = $item->start_session->getTimestamp();
//                $endTimestamp = $item->end_session->getTimestamp();
//                $startDate = $startTimestamp - ($startTimestamp % $interval) + $interval;
//                dd($startDate);
//                $endDate = $endTimestamp - ($endTimestamp % $interval) + $interval;
//
//                for ($offset = $endDate - $startDate; $offset > 0; $offset -= $interval) {
//                    $position = $startDate + $offset;
//
//                    if (!isset($hashTable[$position]) || is_null($hashTable[$position])) {
//                        $hashTable[$position] = 0;
//                    }
//
//                    $hashTable[$position]++;
//                }
//
//                return $hashTable;
//            }, []);
//
//        return collect($result);
    }
}
