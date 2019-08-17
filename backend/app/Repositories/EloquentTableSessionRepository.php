<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Session;
use App\Repositories\Contracts\TableSessionRepository;
use Illuminate\Database\Eloquent\Collection;

final class EloquentTableSessionRepository implements TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(string $startDate, string $endDate, string $parameter): Collection
    {
        return Session::whereDateBetween($startDate, $endDate)
            ->avgSessionsTime()
            ->groupByParameter($parameter)
            ->get();
    }
}