<?php

declare(strict_types=1);

namespace App\Repositories;

use app\Repositories\Contracts\TableVisitRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentTableVisitRepository implements TableVisitRepository
{
    public function countByGeoPosition(int $website_id, string $startDate, string $endDate): int
    {
        return DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select('visits.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->count();
    }

    public function countBySession(int $website_id, string $startDate, string $endDate): int
    {
        return DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select('visits.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->count();
    }

    public function countBySessionAndSystem(int $website_id, string $startDate, string $endDate): int
    {
        return DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select('visits.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->count();
    }

    public function groupByCity(int $website_id, string $startDate, string $endDate): Collection
    {
        $count = $this->countByGeoPosition($website_id, $startDate, $endDate);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'geo_positions.city as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy('geo_positions.city')
            ->get();

        return new Collection($visits);
    }

    public function groupByCountry(int $website_id, string $startDate, string $endDate): Collection
    {
        $count = $this->countByGeoPosition($website_id, $startDate, $endDate);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'geo_positions.country as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy('geo_positions.country')
            ->get();

        return new Collection($visits);
    }

    public function groupByLanguage(int $website_id, string $startDate, string $endDate): Collection
    {
        $count = $this->countBySession($website_id, $startDate, $endDate);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'sessions.language as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy('sessions.language')
            ->get();

        return new Collection($visits);
    }

    public function groupByBrowser(int $website_id, string $startDate, string $endDate): Collection
    {
        $count = $this->countBySessionAndSystem($website_id, $startDate, $endDate);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'systems.browser as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy('systems.browser')
            ->get();

        return new Collection($visits);
    }

    public function groupByOperatingSystem(int $website_id, string $startDate, string $endDate): Collection
    {
        $count = $this->countBySessionAndSystem($website_id, $startDate, $endDate);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'systems.os as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy('systems.os')
            ->get();

        return new Collection($visits);
    }

    public function groupByScreenResolution(int $website_id, string $startDate, string $endDate): Collection
    {
        $count = $this->countBySessionAndSystem($website_id, $startDate, $endDate);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), DB::raw("CONCAT(systems.resolution_height, 'x', systems.resolution_width) as parameter_value"))
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->get();

        return new Collection($visits);
    }
}