<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visits\GetBounceRateChartByDateRangeAction;
use App\Actions\Visits\GetBounceRateChartByDateRangeRequest;
use App\Actions\Visits\GetPageViewsRequest;
use App\Actions\Visits\GetPageViewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetBounceRateChartHttpRequest;
use App\Http\Requests\Api\GetPageViewsFilterHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Resources\VisitResource;
use App\Http\Response\ApiResponse;

final class VisitController extends Controller
{
    private $getPageViewsAction;
    private $getChartBounceRateAction;

    public function __construct(
        GetPageViewsAction $getPageViewsAction,
        GetBounceRateChartByDateRangeAction $getChartBounceRateAction
    ) {
        $this->getPageViewsAction = $getPageViewsAction;
        $this->getChartBounceRateAction = $getChartBounceRateAction;
    }

    public function getPageViews(GetPageViewsFilterHttpRequest $request)
    {
        $response = $this->getPageViewsAction->execute(GetPageViewsRequest::fromRequest($request));

        return ApiResponse::success(new VisitResource($response->views()));
    }

    public function getChartBounceRate(GetBounceRateChartHttpRequest $request): ApiResponse
    {
        $response = $this->getChartBounceRateAction->execute(GetBounceRateChartByDateRangeRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->getVisitsBounceRateCollection()));
    }
}
