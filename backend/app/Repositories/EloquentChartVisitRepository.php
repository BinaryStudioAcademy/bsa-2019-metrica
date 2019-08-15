<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visits\PageViewsFilterData;
use App\Entities\Visit;
use App\Repositories\Contracts\ChartVisitRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartVisitRepository implements ChartVisitRepository
{

    public function findByFilter(PageViewsFilterData $filterData, int $interval): Collection
    {
        $result =  DB::select( (string)DB::raw("SELECT COUNT(*) as visits, date FROM (
                    SELECT visits.*,
                    (extract(epoch FROM created_at) - MOD( (CAST (extract(epoch FROM created_at) AS INTEGER)), :period_in_seconds)) AS date
                   FROM visits 
                   WHERE extract(epoch FROM created_at) >= :start_date
                   AND
                   extract(epoch FROM created_at) <= :end_date 
                   ) AS periods
                   GROUP BY date"), [
            'period_in_seconds' => $interval,
            'start_date' => $filterData->getStartDate()->getTimestamp(),
            'end_date' => $filterData->getEndDate()->getTimestamp(),
        ]);
        return Visit::modelsFromRawResults($result);
    }
}
