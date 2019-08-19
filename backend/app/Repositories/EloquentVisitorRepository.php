<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Entities\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentVisitorRepository implements VisitorRepository
{
    public function all(): Collection
    {
        return Visitor::all();
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

    public function newestCount(NewVisitorsCountFilterData $filterData): int
    {
        return Visitor::whereCreatedAtBetween($filterData->getStartDate(), $filterData->getEndDate())
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
}
