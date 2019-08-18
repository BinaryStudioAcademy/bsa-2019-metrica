<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\Entities\Session;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Entities\Visitor;
use Illuminate\Support\Facades\DB;
use App\Actions\Sessions\AverageSessionFilter;
use App\Actions\Sessions\CountSessionsFilter;

class EloquentSessionRepository implements SessionRepository
{
    public function getCollection(): Collection
    {
        return collect([]);
    }

    public function countSessions(CountSessionsFilter $filter): int
    {
        return Session::whereIn('visitor_id', $filter->getVisitorsIDs())
                    ->where('start_session', '>=', $filter->getStartDate())
                    ->where('start_session', '<=', $filter->getEndDate())
                    ->count();
    }

    public function getAvgSession(AverageSessionFilter $filter): Collection
    {
        return DB::table('sessions')
                ->selectRaw('EXTRACT(EPOCH FROM (AVG(end_session - start_session))) as avg')
                ->whereIn('visitor_id', $filter->getVisitorsIDs())
                ->where('start_session', '>=', $filter->getStartDate())
                ->where('start_session', '<=', $filter->getEndDate())
                ->get();
    }
}
