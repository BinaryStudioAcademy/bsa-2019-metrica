<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Entities\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentVisitorRepository implements VisitorRepository
{
    public function all(): Collection
    {
        return Visitor::all();
    }

    public function countVisitorsBetweenDate(string $from, string $to): int
    {
        return Visitor::whereHas('sessions', function (Builder $query) use ($from, $to) {
            $query->whereDateBetween($from, $to);
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

    public function countSinglePageInactiveSessionBetweenDate(string $from, string $to): int
    {
        return Visitor::has('sessions', '=', '1')
            ->whereHas('sessions', function (Builder $query) use ($from, $to) {
                $query->whereDateBetween($from, $to)
                    ->has('visits', '=', '1')
                    ->inactive($to);
            })
            ->forUserWebsite()
            ->count();
    }
}
