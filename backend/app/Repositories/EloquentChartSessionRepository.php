<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Session;
use App\Model\Sessions\AverageSessionByIntervalFilterData;
use App\Repositories\Contracts\ChartSessionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class EloquentChartSessionRepository implements ChartSessionRepository
{

    public function getAverageSessionByInterval(
        AverageSessionByIntervalFilterData $filter,
        Collection $visitorsId
    ): array
    {
        $sessionCount = Session::whereIn('visitor_id', $visitorsId)
            ->where('start_session', '>=', $filter->getStartDate())
            ->where('start_session', '<=', $filter->getEndDate())
            ->count();
        $sessions = DB::table('sessions')
            ->selectRaw('EXTRACT(EPOCH FROM (AVG(end_session - start_session))) as avg')
            ->whereIn('visitor_id', $filter->getVisitorsIDs())
            ->where('start_session', '>=', $filter->getStartDate())
            ->where('start_session', '<=', $filter->getEndDate())
            ->get();

    }
}
