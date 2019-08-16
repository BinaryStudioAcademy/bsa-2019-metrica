<?php


namespace App\Actions\Visitors;

use App\Repositories\Contracts\ChartVisitorsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetNewChartVisitorsByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetNewChartVisitorsByDateRangeRequest $request):GetNewChartVisitorsByDateRangeResponse
    {
        $startData = Carbon::createFromTimestampUTC($request->getStartDate())->toDateTimeString();
        $endData = Carbon::createFromTimestampUTC($request->getEndDate())->toDateTimeString();
        $response = $this->repository->getNewVisitorsByDate($startData,$endData,$request->getPeriod(),Auth::user()->id);
        return new GetNewChartVisitorsByDateRangeResponse($response);
    }
}
