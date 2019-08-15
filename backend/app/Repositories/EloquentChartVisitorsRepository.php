<?php


namespace App\Repositories;


use App\Actions\Visitors\GetNewVisitorsByDateRangeRequest;
use App\Repositories\Contracts\ChartVisitorsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentChartVisitorsRepository implements ChartVisitorsRepository
{
    public function getNewVisitorsByDate(GetNewVisitorsByDateRangeRequest $request)
    {
        $userId = Auth::user()->id;
        $websiteId = DB::select('SELECT id FROM websites where user_id = :user_id', [
            'user_id' => $userId
        ]);
        $websiteId = [11, 14];
        $startData = Carbon::createFromTimestampUTC($request->getStartDate())->toDateTimeString();
        $endData = Carbon::createFromTimestampUTC($request->getEndDate())->toDateTimeString();

        $res = DB::select('SELECT COUNT(*), period from(SELECT visitors.*, (extract(epoch from created_at)::numeric-(extract(epoch from created_at)::numeric % :period)) as period
FROM "visitors" WHERE created_at >= :startData and created_at <= :endData and website_id in (11,14)) as periods group by period',
            ['startData' => $startData,
                'endData' => $endData,
                'period' => 1
            ]);
//                'website_id' => $websiteId]);
//        return $websiteId;
        return $res;
    }
}
