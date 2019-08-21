<?php
declare(strict_types=1);

namespace App\Actions\Sessions;


use App\Repositories\Contracts\ChartSessionRepository;
use App\Repositories\Contracts\VisitorRepository;
use Illuminate\Support\Collection;

final class GetAverageSessionByIntervalAction
{
    private $repository;
    private $visitorRepository;

    public function __construct(
        ChartSessionRepository $repository,
        VisitorRepository $visitorRepository
    ) {
        $this->repository = $repository;
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(GetAverageSessionByIntervalRequest $request): GetAverageSessionByIntervalResponse
    {
        $filterData = $request->getFilterData();
        $from = $filterData->getStartDate();
        $to = $filterData->getEndDate();
        $timeFrame = $filterData->getTimeFrame();
        //$websiteId = auth()->user()->website->id;
        $visitorsIDsOfWebsite = $this->visitorRepository->getVisitorsOfWebsite((int) 1)
            ->pluck('id');
        $collection = new Collection();

        $start = $from->getTimestamp();
        $end = $to->getTimestamp();

        do {
            $all = $this->repository->getAverageSessionByInterval($filterData, $visitorsIDsOfWebsite);
        } while (($start += $timeFrame) <= $end);
    }
}
