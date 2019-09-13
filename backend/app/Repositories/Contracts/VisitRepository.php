<?php

namespace App\Repositories\Contracts;

use App\Entities\Visit;
use Illuminate\Database\Eloquent\Collection;

interface VisitRepository
{
    public function save(Visit $visit): Visit;

    public function getVisitsCountByHourAndDay(string $startDate, string $endDate, int $websiteId, string $timeZone): Collection;

    public function findBySessionId(int $sessionId): Collection;
}
