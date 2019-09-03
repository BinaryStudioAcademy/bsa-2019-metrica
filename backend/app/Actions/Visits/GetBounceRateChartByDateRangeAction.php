<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\DataTransformer\ChartValue;
use App\Entities\Website;
use App\Repositories\Contracts\ChartVisitRepository;
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
        $to = $request->period()->getEndDate();
        $interval = $request->interval();
        $website = Website::select('id')->where('id', $request->websiteId())
                                        ->first();
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
        $collection = new Collection();
        do {
            $all = $allVisitsByTimeFrame[$start]??0;
            $bounced = $bouncedVisitsByTimeFrame[$start]??0;
            $rate = ($all === 0) ? 0 : ($bounced / $all);
            $collection->add(new ChartValue((string) $start, (string) $rate));
        } while (($start += (int)$interval) <= $end);

        return new GetBounceRateChartByDateRangeResponse($collection);
    }
}