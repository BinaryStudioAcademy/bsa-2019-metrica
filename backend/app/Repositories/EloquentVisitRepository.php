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

    public function getVisitsCountByHourAndDay(string $startDate, string $endDate): Collection
    {
        return Visit::select(DB::raw(
            "extract('hour' FROM visit_time) as hour,
               extract('dow' FROM visit_time) as day,
               count(*) as visits"
            ))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day', 'hour')
            ->get();
    }


    public function findBySessionId(int $sessionId): Collection
    {
        return Visit::where('session_id', $sessionId)->get();
    }
}
