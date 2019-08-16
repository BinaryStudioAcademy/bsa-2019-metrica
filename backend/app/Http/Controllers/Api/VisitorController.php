<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visitors\GetAllVisitorsAction;
use App\Actions\Visitors\GetNewestCountAction;
use App\Actions\Visitors\GetNewestCountRequest;
use App\Actions\Visitors\GetBounceRateAction;
use App\Actions\Visitors\GetBounceRateRequest;
use App\Actions\Visitors\GetNewVisitorsAction;
use App\Actions\Visitors\GetNewChartVisitorsByDateRangeAction;
use App\Actions\Visitors\GetNewChartVisitorsByDateRangeRequest;
use App\Http\Requests\Visitors\GetNewVisitorCountFilterHttpHttpRequest;
use App\Http\Requests\Visitors\GetNewChartVisitorsHttpRequest;
use App\Http\Resources\ChartNewVisitorResource;
use App\Http\Resources\ChartNewVisitorResourceCollection;
use App\Http\Resources\VisitorCountResource;
use App\Http\Requests\Api\GetBounceRateHttpRequest;
use App\Http\Resources\BounceRateResource;
use App\Http\Resources\VisitorResourceCollection;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;

final class VisitorController extends Controller
{
    private $getAllVisitorsAction;
    private $getNewVisitorsAction;
    private $getNewVisitorsByDateRangeAction;
    private $getBounceRateAction;

    public function __construct(
        GetAllVisitorsAction $getAllVisitorsAction,
        GetNewVisitorsAction $getNewVisitorsAction,
        GetNewChartVisitorsByDateRangeAction $getNewVisitorsByDateRangeAction,
        GetBounceRateAction $getBounceRateAction
    ) {
        $this->getAllVisitorsAction = $getAllVisitorsAction;
        $this->getNewVisitorsAction = $getNewVisitorsAction;
        $this->getNewVisitorsByDateRangeAction = $getNewVisitorsByDateRangeAction;
        $this->getBounceRateAction = $getBounceRateAction;
    }

    public function getAllVisitors(): ApiResponse
    {
        $response = $this->getAllVisitorsAction->execute();

        return ApiResponse::success(new VisitorResourceCollection($response->visitors()));
    }

    public function getNewVisitors(): ApiResponse
    {
        $response = $this->getNewVisitorsAction->execute();

        return ApiResponse::success(new VisitorResourceCollection($response->visitors()));
    }

    public function getNewVisitorsCountForFilterData(GetNewVisitorCountFilterHttpHttpRequest $request, GetNewestCountAction $action): ApiResponse
    {
        $response = $action->execute(GetNewestCountRequest::fromRequest($request));
        return ApiResponse::success(new VisitorCountResource($response->getCount()));
    }

    public function getNewVisitorsByDateRange(GetNewChartVisitorsHttpRequest $request)
    {
        $response = $this->getNewVisitorsByDateRangeAction->execute(GetNewChartVisitorsByDateRangeRequest::fromRequest($request));
        return ApiResponse::success(new ChartNewVisitorResourceCollection($response->getVisitorsByDateRange()));
    }

    public function getBounceRate(GetBounceRateHttpRequest $request): ApiResponse
    {
        $response = $this->getBounceRateAction->execute(
            GetBounceRateRequest::fromRequest($request)
        );

        return ApiResponse::success(new BounceRateResource($response));
    }
}
