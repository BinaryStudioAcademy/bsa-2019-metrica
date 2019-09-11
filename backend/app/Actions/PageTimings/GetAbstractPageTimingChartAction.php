<?php


namespace App\Actions\PageTimings;

use App\DataTransformer\ChartValue;
use App\Repositories\Contracts\ChartPageTimingRepository;
use App\Utils\DatePeriod;
use Carbon\Carbon;
use Illuminate\Support\Collection;

abstract class GetAbstractPageTimingChartAction
{
    protected $repository;

    public function __construct(ChartPageTimingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetChartRequest $request): GetChartResponse
    {
        $from = $request->period()->getStartDate();
        $minStarDate = new Carbon('01/01/2018');
        $from = ($from < $minStarDate)? $minStarDate : $from;
        $to = $request->period()->getEndDate();
        $timeFrame = (int) $request->interval();

        $avgPageLoadingByTimeFrameValues = $this->getData($request->period(), $request->interval());
        $start = $from->getTimestamp() - ($from->getTimestamp() % $timeFrame);
        $end = $to->getTimestamp() - ($to->getTimestamp() % $timeFrame);

        $hasFirst = false;
        $length = 0;
        $lastLength = 0;
        $items = [];
        do {
            $value = $avgPageLoadingByTimeFrameValues[$start]??0;

            if (!$hasFirst && $value === 0) {
                continue;
            }
            $length++;
            $hasFirst = true;
            if ($value !== 0) {
                $lastLength = $length;
            }
            $items[] = new ChartValue((string) $start, (string) $value);
        } while (($start += $timeFrame) <= $end);

        $collection = new Collection(array_slice($items, 0, $lastLength));

        return new GetChartResponse($collection);
    }

    abstract protected function getData(DatePeriod $datePeriod, string $period): array ;
}

