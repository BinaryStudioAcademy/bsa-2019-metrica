<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Repositories\Contracts\ErrorReport\ErrorReportRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetChartErrorByDateRangeAction
{
    private $repository;

    public function __construct(ErrorReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetChartErrorByDateRangeRequest $request): GetChartErrorByDateRangeResponse
    {
        $startData = Carbon::createFromTimestampUTC(
            $request->period()->getStartDate()->getTimestamp()
        )->toDateTimeString();

        $endData = Carbon::createFromTimestampUTC(
            $request->period()->getEndDate()->getTimestamp()
        )->toDateTimeString();

        $response = $this->repository->getErrorsCountByDate(
            $startData,
            $endData,
            $request->interval(),
            $request->websiteId()
        );
        return new GetChartErrorByDateRangeResponse($response);
    }
}
