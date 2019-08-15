<?php


namespace App\Actions\Visitors;


use App\Repositories\Contracts\ChartVisitorsRepository;

class GetNewVisitorsByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetNewVisitorsByDateRangeRequest $request)
    {
        $res = $this->repository->getNewVisitorsByDate($request);
        return $res;
//        return new GetNewVisitorsByDateRangeResponse($res);
    }
}
