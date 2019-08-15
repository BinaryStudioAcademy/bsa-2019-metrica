<?php


namespace App\Actions\Visitors;

use App\Repositories\Contracts\ChartVisitorsRepository;

class GetNewChartVisitorsByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetNewChartVisitorsByDateRangeRequest $request):GetNewChartVisitorsByDateRangeResponse
    {
        $response = $this->repository->getNewVisitorsByDate($request);
        return new GetNewChartVisitorsByDateRangeResponse($response);
    }
}
