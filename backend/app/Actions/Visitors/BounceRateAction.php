<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\DataTransformer\ChartValue;
use App\Repositories\Contracts\ChartVisitorsRepository;
use Illuminate\Support\Collection;

final class BounceRateAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(BounceRateRequest $request): BounceRateResponse
    {
        $filterData = $request->getFilterData();
        $from = $filterData->getStartDate();
        $to = $filterData->getEndDate();
        $timeFrame = $filterData->getTimeFrame();

        $allVisitorsByTimeFrameValues = $this->repository->getVisitorsCountByTimeFrame($filterData);
        $bounceVisitorsByTimeFrameValues = $this->repository->getBouncedVisitorsCountByTimeFrame($filterData);

        $start = $from->getTimestamp() - ($from->getTimestamp()%$timeFrame);
        $end = $to->getTimestamp() - ($to->getTimestamp()%$timeFrame);
        $collection = new Collection();
        do {
            $all = $allVisitorsByTimeFrameValues[$start]??0;
            $bounced = $bounceVisitorsByTimeFrameValues[$start]??0;
            $rate = ($all === 0) ? 0 : ($bounced / $all);
            $collection->add(new ChartValue((string) $start, (string) $rate));
        } while (($start+=$timeFrame)<=$end);

        return new BounceRateResponse($collection);
    }
}
