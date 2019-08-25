<?php

namespace App\Repositories\Contracts;

use App\Contracts\Visitors\NewVisitorsCountFilterData;
use App\Entities\Visitor;
use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Collection;

interface VisitorRepository
{
    public function all(): Collection;

    public function getById(int $id): Visitor;

    public function save(Visitor $visitor): Visitor;

    public function updateLastActivity(Visitor $visitor): void;

    public function countVisitorsBetweenDate(DatePeriod $period): int;

    public function newest(): Collection;

    public function newestCount(NewVisitorsCountFilterData $filterData, int $websiteId): int;

    public function countSinglePageInactiveSessionBetweenDate(DatePeriod $period): int;

    public function getVisitorsOfWebsite(int $websiteId): Collection;

    public function countAllVisitorsGroupByCountry(string $startDate, string $endDate): Collection;
}
