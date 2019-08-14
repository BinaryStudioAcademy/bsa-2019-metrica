<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentTableVisitorsRepository implements TableVisitorsRepository
{
    public function groupByCity(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', function($join) use ($from, $to)
            {
                $join->on('visitors.id', '=', 'visits.visitor_id')
                    ->where('visits.visit_time', '>', $from)
                    ->andWhere('visits.visit_time', '<', $to);
            })
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('demographics', 'demographics.id', '=', 'sessions.demographic_id')
            ->join('geo_positions_id', 'demographics.id', '=', 'sessions.demographic_id')
            ->select('count(distinct visitors.id) as count_visitors', 'sum(count_visitors)', 'geo_positions_id.city as param_value')
            ->get();
    }

    public function groupByCountry(string $from, string $to): Collection
    {

    }

    public function groupByLanguage(string $from, string $to): Collection
    {

    }

    public function groupByBrowser(string $from, string $to): Collection
    {

    }

    public function groupByOperatingSystem(string $from, string $to): Collection
    {

    }

    public function groupByScreenResolution(string $from, string $to): Collection
    {

    }
}