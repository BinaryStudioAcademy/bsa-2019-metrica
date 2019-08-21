<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Session;
use App\Repositories\Contracts\ChartSessionRepository;
use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

final class EloquentChartSessionRepository implements ChartSessionRepository
{

    public function getSessionByInterval(
        DatePeriod $period,
        Collection $visitorsId
    ): Collection
    {
        return Session::whereSessionDateBetween($period)
            ->whereIn('visitor_id', $visitorsId)
            ->get();
    }
}
