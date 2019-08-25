<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Entities\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use App\Utils\DatePeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentVisitorRepository implements VisitorRepository
{
    public function all(): Collection
    {
        return Visitor::all();
    }

    public function getById(int $id): Visitor
    {
        return Visitor::findOrFail($id);
    }

    public function save(Visitor $visitor): Visitor
    {
        $visitor->save();
        return $visitor;
    }

    public function updateLastActivity(Visitor $visitor): void
    {
        $visitor->last_activity = Carbon::now()->toDateTimeString();
        $visitor->save();
    }

    public function countVisitorsBetweenDate(DatePeriod $period): int
    {
        return Visitor::whereHas('sessions', function (Builder $query) use ($period) {
            $query->whereDateBetween($period);
        })
            ->forUserWebsite()
            ->count();
    }

    public function newest(): Collection
    {
        return new Collection();
    }

    public function newestCount(NewVisitorsCountFilterData $filterData, int $websiteId): int
    {
        return Visitor::whereCreatedAtBetween($filterData->getStartDate(), $filterData->getEndDate())
            ->where('website_id', $websiteId)
            ->count();
    }

    public function countSinglePageInactiveSessionBetweenDate(DatePeriod $period): int
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($period) {
                $query->whereDateBetween($period)
                    ->has('visits', '=', '1')
                    ->inactive($period->getEndDate());
            })
            ->forUserWebsite()
            ->count();
    }

    public function getVisitorsOfWebsite(int $websiteId): Collection
    {
        return Visitor::where('website_id', $websiteId)->get();
    }

    public function countAllVisitorsGroupByCountry(DatePeriod $period): Collection
    {
        return Visitor::forUserWebsite()
                ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
                ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
                ->select(DB::raw('count(visitors.id) as all_visitors_count, geo_positions.country as country'))
                ->whereBetween('visits.visit_time', [$period->getEndDate(), $period->getEndDate()])
                ->groupBy('geo_positions.country')
                ->get();
    }
}
