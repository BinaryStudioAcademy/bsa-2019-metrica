<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\ChartVisitorsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetNewChartVisitorsByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitorsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetNewChartVisitorsByDateRangeRequest $request)
    {
        $startData = Carbon::createFromTimestampUTC($request->period()->getStartDate()->getTimestamp())->toDateTimeString();
        $endData = Carbon::createFromTimestampUTC($request->period()->getEndDate()->getTimestamp())->toDateTimeString();
        $response = $this->repository->getNewVisitorsByDate($startData, $endData, $request->interval(), $request->websiteId());
        return new GetNewChartVisitorsByDateRangeResponse($response);
    }
}
