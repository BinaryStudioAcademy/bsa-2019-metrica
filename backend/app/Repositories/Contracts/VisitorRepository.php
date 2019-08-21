<?php

namespace App\Repositories\Contracts;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Entities\Visitor;
use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Collection;

interface VisitorRepository
{
    public function all(): Collection;

    public function getById(string $id): Visitor;

    public function countVisitorsBetweenDate(DatePeriod $period): int;

    public function newest(): Collection;

    public function newestCount(NewVisitorsCountFilterData $filterData): int;

    public function countSinglePageInactiveSessionBetweenDate(DatePeriod $period): int;

    public function getVisitorsOfWebsite(int $websiteId): Collection;
}
