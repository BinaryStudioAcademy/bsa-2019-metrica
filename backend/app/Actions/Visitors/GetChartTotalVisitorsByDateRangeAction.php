<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Repositories\Contracts\ChartVisitorRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetChartTotalVisitorsByDateRangeAction
{
    private $repository;

    public function __construct(ChartVisitorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetChartTotalVisitorsByDateRangeRequest $request)
    {
        $startDate = Carbon::createFromTimestampUTC(
            $request->period()->getStartDate()->getTimestamp()
        )->toDateTimeString();
        $endDate = Carbon::createFromTimestampUTC(
            $request->period()->getEndDate()->getTimestamp()
        )->toDateTimeString();

        $response = $this->repository->getTotalVisitorsByDateRange(
            $startDate, $endDate, $request->interval(), Auth::id()
        );

        return new GetChartTotalVisitorsByDateRangeResponse($response);

    }
}