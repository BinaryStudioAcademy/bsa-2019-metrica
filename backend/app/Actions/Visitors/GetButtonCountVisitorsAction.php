<?php


namespace App\Actions\Visitors;


use App\Repositories\Contracts\ChartVisitorsRepository;

class GetButtonCountVisitorsAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetButtonCountVisitorsRequest $request)
    {

    }
}
