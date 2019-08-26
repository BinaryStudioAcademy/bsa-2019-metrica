<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Collection;
use App\Entities\Session;
use Illuminate\Support\Facades\DB;
use App\Actions\Sessions\AverageSessionFilter;
use App\Actions\Sessions\CountSessionsFilter;

final class EloquentSessionRepository implements SessionRepository
{
    public function getCollection(): Collection
    {
        return collect([]);
    }

    public function save(Session $session): Session
    {
        $session->save();
        return $session;
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

    public function lastActiveByVisitorId(int $visitorId): ?Session
    {
        return Session::whereVisitorId($visitorId)
            ->whereTime('end_session', '>', (Carbon::now())->subMinutes(30)->toDateTimeString())->first();
    }

    public function updateEndSession(Session $session): void
    {
        $session->end_session = Carbon::now()->toDateTimeString();
        $session->save();
    }

    public function getAvgSessionTimeGroupByCountry(string $startDate, string $endDate): Eloquent\Collection
    {
        return Session::forUserWebsite()
            ->whereBetween('sessions.start_session', [$startDate, $endDate])
            ->avgSessionTime()
            ->join('visits', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
            ->groupBy('geo_positions.country')
            ->addSelect('geo_positions.country as country')
            ->get();
    }
}
