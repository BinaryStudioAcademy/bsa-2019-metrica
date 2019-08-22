<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\DataTransformer\TableValue;

final class EloquentTableVisitorsRepository implements TableVisitorsRepository
{
    public function groupByCity(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'geo_positions.city as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('geo_positions.city')
            ->get();

        return $this->mapToTableValues($visitors, 'city');
    }

    public function groupByCountry(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'geo_positions.country as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('geo_positions.country')
            ->get();

        return $this->mapToTableValues($visitors, 'country');
    }

    public function groupByLanguage(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'sessions.language as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('sessions.language')
            ->get();

        return $this->mapToTableValues($visitors, 'language');
    }

    public function groupByBrowser(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'systems.browser as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('systems.browser')
            ->get();

        return $this->mapToTableValues($visitors, 'browser');
    }

    public function groupByOperatingSystem(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'systems.os as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('systems.os')
            ->get();

        return $this->mapToTableValues($visitors, 'operating_system');
    }

    public function groupByScreenResolution(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), DB::raw("CONCAT(systems.resolution_height, 'x', systems.resolution_width) as parameter_value"))
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->get();

        return $this->mapToTableValues($visitors, 'screen_resolution');
    }

    private function mapToTableValues(Collection $visitors, string $parameter)
    {
        return $visitors->map(function($item) use ($parameter) {
            return new TableValue(
                $parameter,
                $item->parameter_value,
                strval($item->count_visitors),
                $item->count_visitors / $item->total_count * 100
            );
        });
    }
}