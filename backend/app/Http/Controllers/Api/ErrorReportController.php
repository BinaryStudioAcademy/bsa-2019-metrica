<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\ErrorReport\GetChartErrorByDateRangeAction;
use App\Actions\ErrorReport\GetChartErrorByDateRangeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorReport\GetChartErrorByDateRangeHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Response\ApiResponse;

final class ErrorReportController extends Controller
{
    private $getChartErrorByDateRangeAction;

    public function __construct(
        GetChartErrorByDateRangeAction $getChartErrorByDateRangeAction
    ) {
        $this->getChartErrorByDateRangeAction = $getChartErrorByDateRangeAction;
    }

    public function getErrorsCountByDateRange(GetChartErrorByDateRangeHttpRequest $request): ApiResponse
    {
        $response = $this->getChartErrorByDateRangeAction->execute(
            GetChartErrorByDateRangeRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->getErrorCountByDateRange()));
    }
}
