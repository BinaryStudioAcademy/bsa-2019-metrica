<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\ChartValue;
use App\Entities\Website;
use App\Repositories\Contracts\ChartVisitRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class GetBounceRateChartByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetBounceRateChartByDateRangeRequest $request): GetBounceRateChartByDateRangeResponse
    {
        $from = $request->period()->getStartDate();
        $minStarDate = new Carbon('01/01/2018');
        $from = ($from < $minStarDate)? $minStarDate : $from;
        $to = $request->period()->getEndDate();
        $interval = $request->interval();
        $website = Website::select('id')->where('user_id', Auth::id())->first();
        $allVisitsByTimeFrame = $this->repository->getVisitsCountByTimeFrame(
            $request->period(),
            (int)$interval,
            $website->id
        );
        $bouncedVisitsByTimeFrame = $this->repository->getBouncedVisitsCountByTimeFrame(
            $request->period(),
            (int)$interval,
            $website->id
        );

        $start = $from->getTimestamp() - ($from->getTimestamp()%(int)$interval);
        $end = $to->getTimestamp() - ($to->getTimestamp()%(int)$interval);
        $hasFirst = false;
        $length = 0;
        $lastLength = 0;
        $items = [];
        do {
            $all = $allVisitsByTimeFrame[$start]??0;
            $bounced = $bouncedVisitsByTimeFrame[$start]??0;
            $rate = ($all === 0) ? 0 : ($bounced / $all);
            if (!$hasFirst && $rate === 0) {
                continue;
            }
            $length++;
            $hasFirst = true;
            if ($rate !== 0) {
                $lastLength = $length;
            }
            $items[] = new ChartValue((string)$start, (string)$rate);
        } while (($start += (int)$interval) <= $end);

        $collection = new Collection(array_slice($items, 0, $lastLength));

        return new GetBounceRateChartByDateRangeResponse($collection);
    }
}
