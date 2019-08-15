<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class EloquentTableVisitorsRepository implements TableVisitorsRepository
{
    private $website_id;

    public function __construct () {
        $this->website_id = Auth::user()->getWebsite()->id;
    }

    public function getCount(string $from, string $to): int
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->select('distinct visitors.id')
            ->whereBetween('visits.visit_time', [$from, $to])
            ->count();

        return $count;
    }

    public function groupByCity(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(distinct visitors.id) as count_visitors'), DB::raw("{$this->getCount($from, $to)} as total_count"), 'geo_positions.city as parameter_value')
            ->where('visits.website_id', '=', $this->website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('geo_positions.city')
            ->get();

        return new Collection($visitors);
    }

    public function groupByCountry(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(distinct visitors.id) as count_visitors'), DB::raw("{$this->getCount($from, $to)} as total_count"), 'geo_positions.country as parameter_value')
            ->where('visits.website_id', '=', $this->website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('geo_positions.country')
            ->get();

        return new Collection($visitors);
    }

    public function groupByLanguage(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('languages', 'languages.id', '=', 'sessions.language_id')
            ->select(DB::raw('COUNT(distinct visitors.id) as count_visitors'), DB::raw("{$this->getCount($from, $to)} as total_count"), 'languages.language as parameter_value')
            ->where('visits.website_id', '=', $this->website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('languages.id')
            ->get();

        return new Collection($visitors);
    }

    public function groupByBrowser(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->join('browsers', 'browsers.id', '=', 'systems.browser_id')
            ->select(DB::raw('COUNT(distinct visitors.id) as count_visitors'), DB::raw("{$this->getCount($from, $to)} as total_count"), 'browsers.name as parameter_value')
            ->where('visits.website_id', '=', $this->website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('browsers.id')
            ->get();

        return new Collection($visitors);
    }

    public function groupByOperatingSystem(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->join('os', 'os.id', '=', 'systems.os_id')
            ->select(DB::raw('COUNT(distinct visitors.id) as count_visitors'), DB::raw("{$this->getCount($from, $to)} as total_count"), 'os.name as parameter_value')
            ->where('visits.website_id', '=', $this->website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('os.id')
            ->get();

        return new Collection($visitors);
    }

    public function groupByScreenResolution(string $from, string $to): Collection
    {
        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(distinct visitors.id) as count_visitors'), DB::raw("{$this->getCount($from, $to)} as total_count"), 'systems.screen_resolution as parameter_value')
            ->where('visits.website_id', '=', $this->website_id)
            ->whereBetween('visits.visit_time', [$from, $to])
            ->groupBy('systems.screen_resolution')
            ->get();

        return new Collection($visitors);
    }
}