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

    public function findByFilter(DatePeriod $filterData, int $websiteId): Collection
    {
        $subQuery = "SELECT s.*" .
        "FROM sessions AS s " .
        "WHERE " .
            "s.website_id = " . "$websiteId AND (" .
            $this->toTimestamp('s.start_session') . " >= :start_date AND " .
            $this->toTimestamp('s.start_session') . " <= :end_date) OR (" .
            $this->toTimestamp('s.start_session') . " <= :start_date AND " .
            $this->toTimestamp('s.end_session') . " >= :start_date)";

        $result = DB::select((string)$subQuery, [
        'start_date' => $filterData->getStartDate()->getTimestamp(),
        'end_date' => $filterData->getEndDate()->getTimestamp(),
        ]);

        return collect($result)->map(function ($item) {
            return array(
                $item->start_session,
                $item->end_session,
                $item->website_id,
            );
        });
    }
}
