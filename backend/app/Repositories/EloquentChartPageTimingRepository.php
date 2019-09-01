<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Visit;
use App\Repositories\Contracts\ChartPageTimingRepository;
use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Builder;

final class EloquentChartPageTimingRepository implements ChartPageTimingRepository
{
    public function getAvgPageLoadByDateRange(DatePeriod $datePeriod, string $period): array
    {
        return $this->getAvgPageTimingByDateRange($datePeriod, $period, 'page_load_time');
    }

    private function getAvgPageTimingByDateRange(DatePeriod $datePeriod, string $period, string $pageTiming): array
    {
        $from = $datePeriod->getStartDate();
        $to = $datePeriod->getEndDate();
        $avgPageLoadingByTimeFrame = Visit::query()
            ->whereBetween('visit_time', [$from, $to])
            ->whereHas('visitor', function (Builder $query){
                $query->forUserWebsite();
            })
            ->selectRaw('AVG ('.$pageTiming.') as average')
            ->selectRaw(' (extract(epoch FROM visit_time) - MOD( (CAST (extract(epoch FROM visit_time) AS INTEGER)), ? )) AS period', [$period])
            ->groupBy('period')
            ->get();

        return array_column($avgPageLoadingByTimeFrame->toArray(), 'average', 'period');
    }
}
