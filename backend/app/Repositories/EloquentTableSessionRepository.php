<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Session;
use App\Repositories\Contracts\TableSessionRepository;
use App\Utils\DatePeriod;
use Illuminate\Database\Eloquent\Collection;

final class EloquentTableSessionRepository implements TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(DatePeriod $datePeriod, string $parameter): Collection
    {
        return Session::whereDateBetween($datePeriod)
            ->avgSessionsTime()
            ->groupByParameter($parameter)
            ->count()
            ->get();
    }
}