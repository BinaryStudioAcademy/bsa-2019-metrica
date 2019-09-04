<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\DataTransformer\Visitors\ActiveVisitorItem;
use App\Entities\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use App\Utils\DatePeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;
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

    public function countVisitorsBetweenDate(DatePeriod $period, int $websiteId): int
    {
        return Visitor::whereHas('sessions', function (Builder $query) use ($period) {
            $query->whereDateBetween($period);
        })
            ->whereWebsiteId($websiteId)
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

    public function countSinglePageInactiveSessionBetweenDate(DatePeriod $period, int $websiteId): int
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($period) {
                $query->whereDateBetween($period)
                    ->has('visits', '=', '1')
                    ->inactive($period->getEndDate());
            })
            ->whereWebsiteId($websiteId)
            ->count();
    }

    public function getVisitorsOfWebsite(int $websiteId): Collection
    {
        return Visitor::where('website_id', $websiteId)->get();
    }

    public function countAllVisitorsGroupByCountry(string $startDate, string $endDate, int $websiteId): Collection
    {
        return Visitor::whereWebsiteId($websiteId)
                ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
                ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
                ->select(DB::raw('count(visitors.id) as all_visitors_count, geo_positions.country as country'))
                ->whereBetween('visits.visit_time', [$startDate, $endDate])
                ->groupBy('geo_positions.country')
                ->get();
    }

    public function countNewVisitorsGroupByCountry(string $startDate, string $endDate, int $websiteId): Collection
    {
        return Visitor::whereWebsiteId($websiteId)
            ->where('visitors.created_at', '>', $startDate)
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'geo_positions.id', '=', 'visits.geo_position_id')
            ->select(DB::raw('count(visitors.id) as new_visitors_count, geo_positions.country as country'))
            ->whereBetween('visits.visit_time', [$startDate, $endDate])
            ->groupBy('geo_positions.country')
            ->get();
    }

    public function countInactiveSingleVisitSessionGroupByCountry(string $startDate, string $endDate, int $websiteId): Collection
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($startDate, $endDate) {
                $query->has('visits', '=', '1')
                    ->where('updated_at', '<', (new Carbon($endDate))->subMinutes(30)->toDateTimeString())
                    ->whereBetween('start_session', [$startDate, $endDate]);
            })
            ->whereWebsiteId($websiteId)
            ->join('visits', 'visitors.id', '=', 'visits.visitor_id')
            ->join('geo_positions', 'visits.geo_position_id', '=', 'geo_positions.id')
            ->select(DB::raw('count(visitors.id) as bounced_visitors_count, geo_positions.country as country'))
            ->groupBy('geo_positions.country')
            ->get();
    }
    public function getAllActivityVisitors(int $websiteId): SupportCollection
    {
        $subQueryFirst = "SELECT page_id, visitor_id, max(created_at) over(partition by page_id) max_date FROM visits";
        $subQuerySecond = "select v.visitor_id, p.url, v.max_date from (".$subQueryFirst .") v ";
        $subQueryThird = "left join visitors vs ON v.visitor_id = vs.id
        left join pages p ON v.page_id = p.id
        WHERE v.max_date > NOW() - interval '5 minute'
        AND vs.website_id =".$websiteId." group by v.visitor_id ,p.url, v.max_date order by v.visitor_id desc";
        $query = DB::raw($subQuerySecond.$subQueryThird);
        $result = DB::select((string)$query);

        return collect($result)->map(function ($item) {
            return new ActiveVisitorItem($item->url, $item->visitor_id, $item->max_date);
        });
    }
}
