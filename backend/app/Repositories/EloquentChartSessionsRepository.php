<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\ChartValue;
use App\Repositories\Contracts\ChartSessionsRepository;
use App\Contracts\Common\DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartSessionsRepository implements ChartSessionsRepository
{

    public function findByFilter(DatePeriod $datePeriod, int $interval, int $websiteId): Collection
    {
        $result = DB::select("select COUNT(*) as count, extract(epoch from :startDate::timestamp)+$interval*(
            DIV((extract(epoch from start_session) - 
                    extract(epoch from :startDate::timestamp))::numeric,$interval)) as period
                FROM \"sessions\"
                WHERE website_id=:websiteId AND start_session BETWEEN :startDate AND :endDate
            GROUP BY period
               ORDER BY period", [
            'startDate' => $datePeriod->getStartDate(),
            'endDate' => $datePeriod->getEndDate(),
            'websiteId' => $websiteId
        ]);
        return collect($result)->map(function ($item) {
            return new ChartValue($item->period, (string)$item->count);
        });
    }
}
