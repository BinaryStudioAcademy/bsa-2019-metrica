<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\ErrorReport\GetChartErrorByDateRangeAction;
use App\Actions\ErrorReport\GetChartErrorByDateRangeRequest;
use App\Actions\ErrorReport\GetErrorTableItemsAction;
use App\Http\Requests\ErrorReport\GetErrorTableItemsHttpRequest;
use App\Http\Requests\ErrorReport\GetChartErrorByDateRangeHttpRequest;
use App\Http\Resources\ErrorTableResource;
use App\Http\Response\ApiResponse;
use App\Http\Resources\ChartResource;
use App\Actions\ErrorReport\GetErrorTableItemsRequest;

final class ErrorReportController extends Controller
{
    private $getErrorTableItemsAction;
    private $getChartErrorByDateRangeAction;

    public function __construct(
        GetErrorTableItemsAction $getErrorTableItemsAction,
        GetChartErrorByDateRangeAction $getChartErrorByDateRangeAction
    ) {
        $this->getErrorTableItemsAction = $getErrorTableItemsAction;
        $this->getChartErrorByDateRangeAction = $getChartErrorByDateRangeAction;
    }
    public function getErrorsCountByDateRange(GetChartErrorByDateRangeHttpRequest $request): ApiResponse
    {
        $response = $this->getChartErrorByDateRangeAction->execute(
            GetChartErrorByDateRangeRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->getErrorCountByDateRange()));
    }

    public function getErrorItemsByParameter(GetErrorTableItemsHttpRequest $request)
    {
        $response = $this->getErrorTableItemsAction->execute(
            GetErrorTableItemsRequest::fromRequest($request)
        );

        return ApiResponse::success(
            new ErrorTableResource(
                $response->getGroupedErrors()
            )
        );
    }
}
