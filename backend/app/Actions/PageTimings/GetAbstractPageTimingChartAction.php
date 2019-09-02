<?php


namespace App\Actions\PageTimings;

use App\DataTransformer\ChartValue;
use App\Repositories\Contracts\ChartPageTimingRepository;
use App\Utils\DatePeriod;
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
        $to = $request->period()->getEndDate();
        $timeFrame = (int) $request->interval();

        $avgPageLoadingByTimeFrameValues = $this->getData($request->period(), $request->interval());
        $start = $from->getTimestamp() - ($from->getTimestamp()%$timeFrame);
        $end = $to->getTimestamp() - ($to->getTimestamp()%$timeFrame);
        $collection = new Collection();
        do {
            $value = $avgPageLoadingByTimeFrameValues[$start]??0;
            $collection->add(new ChartValue((string) $start, (string) $value));
        } while (($start+=$timeFrame)<=$end);

        return new GetChartResponse($collection);
    }

    abstract protected function getData(DatePeriod $datePeriod, string $period): array ;
}

