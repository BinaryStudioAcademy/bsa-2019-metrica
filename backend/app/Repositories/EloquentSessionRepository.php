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
                ->whereWebsiteId($filter->websiteId())
                ->whereIn('visitor_id', $filter->getVisitorsIDs())
                ->where('start_session', '>=', $filter->getStartDate())
                ->where('start_session', '<=', $filter->getEndDate())
                ->get();
    }

    public function lastActiveByVisitorId(int $visitorId): ?Session
    {
        return Session::whereVisitorId($visitorId)
            ->where('end_session', '>', (Carbon::now())->subMinutes(30))->first();
    }

    public function updateEndSession(Session $session): void
    {
        $session->end_session = Carbon::now()->toDateTimeString();
        $session->save();
    }

    public function getAvgSessionTimeGroupByCountry(string $startDate, string $endDate, int $websiteId): Eloquent\Collection
    {
        return Session::whereWebsiteId($websiteId)
            ->whereBetween('sessions.start_session', [$startDate, $endDate])
            ->avgSessionTime()
            ->join('visits', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
            ->groupBy('geo_positions.country')
            ->addSelect('geo_positions.country as country')
            ->get();
    }

    public function getCountSessionsGroupByCountry(string $startDate, string $endDate, int $websiteId): Eloquent\Collection
    {
        return Session::whereWebsiteId($websiteId)
            ->whereBetween('sessions.start_session', [$startDate, $endDate])
            ->join('visits', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
            ->select(DB::raw('count(sessions.id) as all_sessions_count, geo_positions.country as country'))
            ->groupBy('geo_positions.country')
            ->get();
    }
}
