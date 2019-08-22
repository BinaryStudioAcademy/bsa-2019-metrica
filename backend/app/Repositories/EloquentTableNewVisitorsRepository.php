<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableNewVisitorsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Entities\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

final class EloquentTableNewVisitorsRepository implements TableNewVisitorsRepository
{
    public function getNewVisitors(int $website_id, string $from, string $to): Collection
    {
        return Visitor::whereBetween('created_at', [
            (new Carbon((int)$from))->toDateTimeString(),
            (new Carbon((int)$to))->toDateTimeString(),
        ])
        ->where('website_id', $website_id)
        ->get(['id', 'created_at']);
    }

    public function countAllVisitors(int $website_id): int
    {
        return Visitor::where('website_id', $website_id)->count();
    }


    public function groupByCity(int $website_id, string $from, string $to): Collection
    {
        $count = $this->countAllVisitors($website_id);

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(DISTINCT visitors.id) as total'),
                     DB::raw("COUNT(DISTINCT visitors.id) * 100 / $count AS percentage" ),
                    'geo_positions.city as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visitors.created_at', [$from, $to])
            ->groupBy('geo_positions.city')
            ->get();

        return new Collection($visitors);
    }

    public function groupByCountry(int $website_id, string $from, string $to): Collection
    {
        $count = $this->countAllVisitors($website_id);

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visitors.id) as total'),
                     DB::raw("COUNT(visitors.id) * 100 / $count AS percentage" ),
                    'geo_positions.country as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visitors.created_at', [$from, $to])
            ->groupBy('geo_positions.country')
            ->get();

        return new Collection($visitors);
    }

    public function groupByLanguage(int $website_id, string $from, string $to): Collection
    {
        $count = $this->countAllVisitors($website_id);

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('COUNT(visitors.id) as total'),
                     DB::raw("COUNT(visitors.id) * 100 / $count AS percentage" ),
                    'sessions.language as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visitors.created_at', [$from, $to])
            ->groupBy('sessions.language')
            ->get();

        return new Collection($visitors);
    }

    public function groupByBrowser(int $website_id, string $from, string $to): Collection
    {
        $count = $this->countAllVisitors($website_id);

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visitors.id) as total'),
                     DB::raw("COUNT(visitors.id) * 100 / $count AS percentage" ),
                    'systems.browser as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visitors.created_at', [$from, $to])
            ->groupBy('systems.browser')
            ->get();

        return new Collection($visitors);
    }

    public function groupByOperatingSystem(int $website_id, string $from, string $to): Collection
    {
        $count = $this->countAllVisitors($website_id);

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visitors.id) as total'),
                     DB::raw("COUNT(visitors.id) * 100 / $count AS percentage" ),
                    'systems.os as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visitors.created_at', [$from, $to])
            ->groupBy('systems.os')
            ->get();

        return new Collection($visitors);
    }

    public function groupByScreenResolution(int $website_id, string $from, string $to): Collection
    {
        $count = $this->countAllVisitors($website_id);

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(visitors.id) as total'),
                     DB::raw("COUNT(visitors.id) * 100 / $count AS percentage" ),
                     DB::raw('CONCAT(systems.resolution_height, \'x\', systems.resolution_width) as parameter_value'))
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('visitors.created_at', [$from, $to])
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->get();

        return new Collection($visitors);
    }
}
