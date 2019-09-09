<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableVisitorsRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\DataTransformer\TableValue;
use App\Entities\Visitor;
use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Builder;

final class EloquentTableVisitorsRepository implements TableVisitorsRepository
{
    public function groupByCity(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->count();


        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'geo_positions.city as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->groupBy('geo_positions.city')
            ->orderBy('count_visitors', 'desc')
            ->get();

        return $this->mapToTableValues($visitors, 'city');
    }

    public function groupByCountry(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select('visitors.id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->count();

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('COUNT(visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'geo_positions.country as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->groupBy('geo_positions.country')
            ->orderBy('count_visitors', 'desc')
            ->get();

        return $this->mapToTableValues($visitors, 'country');
    }

    public function groupByLanguage(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->distinct('visitors.id')
            ->count('visitors.id');

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('COUNT(DISTINCT visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'sessions.language as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->groupBy('sessions.language')
            ->orderBy('count_visitors', 'desc')
            ->get();

        return $this->mapToTableValues($visitors, 'language');
    }

    public function groupByBrowser(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->distinct('visitors.id')
            ->count('visitors.id');

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(DISTINCT visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'systems.browser as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->groupBy('systems.browser')
            ->orderBy('count_visitors', 'desc')
            ->get();

        return $this->mapToTableValues($visitors, 'browser');
    }

    public function groupByOperatingSystem(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->distinct('visitors.id')
            ->count('visitors.id');

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(DISTINCT visitors.id) as count_visitors'), DB::raw("$count as total_count"), 'systems.os as parameter_value')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->groupBy('systems.os')
            ->orderBy('count_visitors', 'desc')
            ->get();

        return $this->mapToTableValues($visitors, 'operating_system');
    }

    public function groupByScreenResolution(int $website_id, string $from, string $to): Collection
    {
        $count = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->distinct('visitors.id')
            ->count('visitors.id');

        $visitors = DB::table('visitors')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('COUNT(DISTINCT visitors.id) as count_visitors'), DB::raw("$count as total_count"), DB::raw("CONCAT(systems.resolution_height, 'x', systems.resolution_width) as parameter_value"))
            ->where('visitors.website_id', '=', $website_id)
            ->whereBetween('sessions.start_session', [$from, $to])
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->orderBy('count_visitors', 'desc')
            ->get();

        return $this->mapToTableValues($visitors, 'screen_resolution');
    }

    private function mapToTableValues(Collection $visitors, string $parameter)
    {
        return $visitors->map(function($item) use ($parameter) {
            return new TableValue(
                $parameter,
                $item->parameter_value,
                (string)($item->count_visitors),
                $item->count_visitors / $item->total_count * 100
            );
        });
    }

    public function getCountVisitorsGroupByCity(DatePeriod $datePeriod): Collection
    {
        return Visitor::forUserWebsite()
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('count(distinct(visitors.id)) as visitors_count, geo_positions.city as city'))
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('geo_positions.city')
            ->get();
    }

    public function getBounceRateGroupByCity(DatePeriod $datePeriod): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($datePeriod) {
                $query->whereDateBetween($datePeriod)
                    ->has('visits', '=', '1')
                    ->inactive($datePeriod->getEndDate());
            })
            ->forUserWebsite()
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
            ->select(DB::raw('count(distinct(visitors.id)) as bounced_visitors_count, geo_positions.city as city'))
            ->groupBy('geo_positions.city')
            ->get();
    }

    public function getCountVisitorsGroupByCountry(DatePeriod $datePeriod): Collection
    {
        return Visitor::forUserWebsite()
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('count(distinct(visitors.id)) as visitors_count, geo_positions.country as country'))
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('geo_positions.country')
            ->get();
    }

    public function getBounceRateGroupByCountry(DatePeriod $datePeriod): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($datePeriod) {
                $query->whereDateBetween($datePeriod)
                    ->has('visits', '=', '1')
                    ->inactive($datePeriod->getEndDate());
            })
            ->forUserWebsite()
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
            ->select(DB::raw('count(distinct(visitors.id)) as bounced_visitors_count, geo_positions.country as country'))
            ->groupBy('geo_positions.country')
            ->get();
    }

    public function getCountVisitorsGroupByLanguage(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('visits')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('count(distinct(visitors.id)) as visitors_count, sessions.language as language'))
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('sessions.language')
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }


    public function getBounceRateRateGroupByLanguage(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($datePeriod) {
                $query->whereDateBetween($datePeriod)
                    ->has('visits', '=', '1')
                    ->inactive($datePeriod->getEndDate());
            })
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->select(DB::raw('count(distinct(visitors.id)) as bounced_visitors_count, sessions.language as language'))
            ->groupBy('sessions.language')
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }

    public function getCountVisitorsGroupByBrowser(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('visits')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('count(distinct(visitors.id)) as visitors_count, systems.browser as browser'))
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('systems.browser')
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }

    public function getBounceRateGroupByBrowser(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($datePeriod) {
                $query->whereDateBetween($datePeriod)
                    ->has('visits', '=', '1')
                    ->inactive($datePeriod->getEndDate());
            })
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('count(distinct(visitors.id)) as bounced_visitors_count, systems.browser as browser'))
            ->groupBy('systems.browser')
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }

    public function getCountVisitorsGroupByOperatingSystem(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('visits')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('count(distinct(visitors.id)) as visitors_count, systems.os as operating_system'))
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy('systems.os')
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }

    public function getBounceRateGroupByOperatingSystem(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($datePeriod) {
                $query->whereDateBetween($datePeriod)
                    ->has('visits', '=', '1')
                    ->inactive($datePeriod->getEndDate());
            })
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('count(distinct(visitors.id)) as bounced_visitors_count, systems.os as operating_system'))
            ->groupBy('systems.os')
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }

    public function getCountVisitorsRateGroupByScreenResolution(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('visits')
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('count(distinct(visitors.id)) as visitors_count'), DB::raw("CONCAT(systems.resolution_height, 'x', systems.resolution_width) as screen_resolution"))
            ->whereBetween('visits.visit_time', [$datePeriod->getStartDate(), $datePeriod->getEndDate()])
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }

    public function getBounceRateGroupByScreenResolution(int $website_id, DatePeriod $datePeriod): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($datePeriod) {
                $query->whereDateBetween($datePeriod)
                    ->has('visits', '=', '1')
                    ->inactive($datePeriod->getEndDate());
            })
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->join('systems', 'systems.id', '=', 'sessions.system_id')
            ->select(DB::raw('count(distinct(visitors.id)) as bounced_visitors_count'), DB::raw("CONCAT(systems.resolution_height, 'x', systems.resolution_width) as screen_resolution"))
            ->groupBy(['systems.resolution_width','systems.resolution_height'])
            ->where('sessions.website_id', '=', $website_id)
            ->get();
    }
}
