<?php
declare(strict_types=1);

namespace App\Actions\Visits;


use App\Repositories\Contracts\ChartVisitRepository;

class GetUniquePageViewsChartAction
{
    private $repository;

    public function __construct(ChartVisitRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUniquePageViewsChartRequest $request)
    {
        $websiteId = auth()->user()->website->id;
//        $response = $this->repository->getUniquePageViews($request->period(),$request->interval(),$websiteId)
    }
}
