<?php

namespace App\Repositories;

use App\Actions\Visitors\GetNewChartVisitorsByDateRangeRequest;
use App\Repositories\Contracts\ChartVisitorsRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentChartVisitorsRepository implements ChartVisitorsRepository
{
    public function getNewVisitorsByDate(GetNewChartVisitorsByDateRangeRequest $request): Collection
    {
        $userId = Auth::user()->id;
        $startData = Carbon::createFromTimestampUTC($request->getStartDate())->toDateTimeString();
        $endData = Carbon::createFromTimestampUTC($request->getEndDate())->toDateTimeString();

        $response = DB::select('SELECT COUNT(*), period from
                        (SELECT visitors.*, (extract(epoch from created_at)::numeric-
                                             (extract(epoch from created_at)::numeric % :period)) as period
                             FROM "visitors" WHERE 
                                      created_at >= :startData and created_at <= :endData and website_id =
                                 (SELECT id FROM websites where user_id = :user_id)) 
                            as periods group by period',
            ['startData' => $startData,
                'endData' => $endData,
                'period' => $request->getPeriod(),
                'user_id' => $userId
            ]);
        return collect($response);
    }
}
