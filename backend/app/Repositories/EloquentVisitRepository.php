<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\VisitRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Entities\Visitor;

final class EloquentVisitRepository implements VisitRepository
{
    public function getPageViews(): Collection
    {
        return new Collection();
    }

    public function getVisitorsOfWebsite(int $websiteId): Collection
    {
        return Visitor::where('website_id', $websiteId)->get();
    }
}