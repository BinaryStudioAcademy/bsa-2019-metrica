<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Visit;
use App\Repositories\Contracts\VisitRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentVisitRepository implements VisitRepository
{
    public function save(Visit $visit): Visit
    {
        $visit->save();
        return $visit;
    }

    public function getVisitsCountByHourAndDay(string $startDate, string $endDate, int $websiteId, string $timeZone): Collection
    {
        return Visit::select(DB::raw(
            "extract('hour' FROM visit_time at time zone '$timeZone') as hour,
               extract('dow' FROM visit_time at time zone '$timeZone') as day,
               count(*) as visits"
            ))
            ->whereBetween('visit_time', [$startDate, $endDate])
            ->groupBy('day', 'hour')
            ->whereHas('session', function ($query) use ($websiteId) {
                $query->whereWebsiteId($websiteId);
            })
            ->get();
    }


    public function findBySessionId(int $sessionId): Collection
    {
        return Visit::where('session_id', $sessionId)->get();
    }
}
