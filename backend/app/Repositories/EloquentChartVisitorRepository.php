<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Visitors\ChartTotalVisitors;
use App\Repositories\Contracts\ChartVisitorRepository;
use App\Utils\DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartVisitorRepository implements ChartVisitorRepository
{
    public function getTotalVisitorsByDateRange(DatePeriod $datePeriod, string $period, int $userId): Collection
    {
        $subQueryFirst = "SELECT id FROM visitors WHERE website_id IN (SELECT id FROM websites WHERE user_id = :user_id)";

        $subQuerySecond = "SELECT visits.*, (" . $this->getPeriod('visit_time', $period) . ") AS period
                             FROM visits 
                             WHERE visit_time >= :startDate and visit_time <= :endDate and visitor_id 
                             IN ($subQueryFirst)";
        $subQueryThird = "SELECT * 
                          FROM (SELECT *, row_number() over (partition by visitor_id order by period) as row_number 
                          FROM ($subQuerySecond) AS periods) as rows where row_number = 1";
        $query = DB::raw("SELECT COUNT(*), period FROM ($subQueryThird) AS periods GROUP BY period;");
        $response = DB::select((string)$query, [
            'startDate' => $datePeriod->getStartDate(),
            'endDate' => $datePeriod->getEndDate(),
            'user_id' => $userId
        ]);
        return collect($response)->map(function ($item) {
            return new ChartTotalVisitors($item->period, (string)$item->count);
        });
    }
    private function toTimestamp(string $columnName): string
    {
        return "EXTRACT(EPOCH FROM $columnName)";
    }
    private function toNumeric(string $expression): string
    {
        return $expression . "::numeric";
    }
    private function getPeriod(string $columnName, $period): string
    {
        return $this->toNumeric($this->toTimestamp($columnName)) . " -(" .
            $this->toNumeric($this->toTimestamp($columnName)) . " % " . $period . ")";
    }
}