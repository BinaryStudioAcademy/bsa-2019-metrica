<?php


namespace App\Actions\Visitors;


use App\Repositories\Contracts\ChartVisitorsRepository;

class GetChartCountVisitorsAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetChartCountVisitorsRequest $request)
    {
        return 'hello!';
    }
}
