<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Visits\TableVisit;
use app\Repositories\Contracts\TableVisitRepository;
use App\Utils\DatePeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentTableVisitRepository implements TableVisitRepository
{
    public function countByGeoPosition(int $website_id, DatePeriod $datePeriod): int
    {
        return DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select('visits.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->count();
    }

    public function countBySession(int $website_id, DatePeriod $datePeriod): int
    {
        return DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select('visits.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->count();
    }

    public function countBySessionAndSystem(int $website_id, DatePeriod $datePeriod): int
    {
        return DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select('visits.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->count();
    }

    public function groupByCity(int $website_id, DatePeriod $datePeriod): Collection
    {
        $count = $this->countByGeoPosition($website_id, $datePeriod);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'geo_positions.city as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('geo_positions.city')
            ->get();

        return collect($visits)->map(function ($item) {
            return new TableVisit('city', $item->parameter_value, (string)$item->total_count, $item->count_visits/$item->total_count*100);
        });
    }

    public function groupByCountry(int $website_id, DatePeriod $datePeriod): Collection
    {
        $count = $this->countByGeoPosition($website_id, $datePeriod);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'geo_positions.country as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('geo_positions.country')
            ->get();

        return collect($visits)->map(function ($item) {
            return new TableVisit('country', $item->parameter_value, (string)$item->total_count, $item->count_visits/$item->total_count*100);
        });
    }

    public function groupByLanguage(int $website_id, DatePeriod $datePeriod): Collection
    {
        $count = $this->countBySession($website_id, $datePeriod);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'sessions.language as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('sessions.language')
            ->get();

        return collect($visits)->map(function ($item) {
            return new TableVisit('language', $item->parameter_value, (string)$item->total_count, $item->count_visits/$item->total_count*100);
        });
    }

    public function groupByBrowser(int $website_id, DatePeriod $datePeriod): Collection
    {
        $count = $this->countBySessionAndSystem($website_id, $datePeriod);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'systems.browser as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('systems.browser')
            ->get();

        return collect($visits)->map(function ($item) {
            return new TableVisit('browser', $item->parameter_value, (string)$item->total_count, $item->count_visits/$item->total_count*100);
        });
    }

    public function groupByOperatingSystem(int $website_id, DatePeriod $datePeriod): Collection
    {
        $count = $this->countBySessionAndSystem($website_id, $datePeriod);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), 'systems.os as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('systems.os')
            ->get();

        return collect($visits)->map(function ($item) {
            return new TableVisit('operating_system', $item->parameter_value, (string)$item->total_count, $item->count_visits/$item->total_count*100);
        });
    }

    public function groupByScreenResolution(int $website_id, DatePeriod $datePeriod): Collection
    {
        $count = $this->countBySessionAndSystem($website_id, $datePeriod);

        $visits = DB::table('visits')
            ->join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visits.id) as count_visits'), DB::raw("$count as total_count"), DB::raw("CONCAT(systems.resolution_height, 'x', systems.resolution_width) as parameter_value"))
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->get();

        return collect($visits)->map(function ($item) {
            return new TableVisit('screen_resolution', $item->parameter_value, (string)$item->total_count, $item->count_visits/$item->total_count*100);
        });
    }
}