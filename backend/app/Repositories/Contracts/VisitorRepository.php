<?php

namespace App\Repositories\Contracts;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use Illuminate\Database\Eloquent\Collection;

interface VisitorRepository
{
    public function all(): Collection;

    public function newest(): Collection;

    public function newestCount(NewVisitorsCountFilterData $filterData): int;

    public function getVisitorsOfWebsite(int $websiteId): Collection;

}
