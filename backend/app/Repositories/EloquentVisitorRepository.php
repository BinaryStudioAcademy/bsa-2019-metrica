<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Entities\Visitor;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Database\Eloquent\Collection;

final class EloquentVisitorRepository implements VisitorRepository
{
    public function all(): Collection
    {
        return new Collection();
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
}
