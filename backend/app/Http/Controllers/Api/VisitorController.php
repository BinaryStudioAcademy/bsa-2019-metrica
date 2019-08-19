<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visitors\GetAllVisitorsAction;
use App\Actions\Visitors\GetButtonCountVisitorsAction;
use App\Actions\Visitors\GetButtonCountVisitorsRequest;
use App\Actions\Visitors\GetNewestCountAction;
use App\Actions\Visitors\GetNewestCountRequest;
use App\Actions\Visitors\GetBounceRateAction;
use App\Actions\Visitors\GetBounceRateRequest;
use App\Actions\Visitors\GetNewVisitorsAction;
use App\Http\Requests\Api\GetButtonCountVisitorsHttpRequest;
use App\Http\Requests\Api\GetNewChartVisitorsHttpRequest;
use App\Http\Requests\Api\GetNewVisitorCountFilterHttpRequest;
use App\Http\Resources\ButtonResource;
use App\Http\Resources\VisitorCountResource;
use App\Http\Requests\Api\GetBounceRateHttpRequest;
use App\Http\Resources\BounceRateResource;
use App\Actions\Visitors\GetVisitorsByParameterAction;
use App\Actions\Visitors\GetVisitorsByParameterRequest;
use App\Http\Requests\Api\GetTableVisitorsByParameterHttpRequest;
use App\Http\Resources\VisitorResourceCollection;
use App\Http\Resources\TableVisitorsResourseCollection;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChartNewVisitorResourceCollection;
use App\Actions\Visitors\GetNewChartVisitorsByDateRangeAction;
use App\Actions\Visitors\GetNewChartVisitorsByDateRangeRequest;

final class VisitorController extends Controller
{
    private $getAllVisitorsAction;
    private $getNewVisitorsAction;
    private $getNewVisitorsByDateRangeAction;
    private $getBounceRateAction;
    private $getButtonCountVisitorsAction;
    private $getVisitorsByParameterAction;

    public function __construct(
        GetAllVisitorsAction $getAllVisitorsAction,
        GetNewVisitorsAction $getNewVisitorsAction,
        GetNewChartVisitorsByDateRangeAction $getNewVisitorsByDateRangeAction,
        GetBounceRateAction $getBounceRateAction,
        GetButtonCountVisitorsAction $getButtonCountVisitorsAction,
        GetVisitorsByParameterAction $getVisitorsByParameterAction
    )
    {
        $this->getAllVisitorsAction = $getAllVisitorsAction;
        $this->getNewVisitorsAction = $getNewVisitorsAction;
        $this->getNewVisitorsByDateRangeAction = $getNewVisitorsByDateRangeAction;
        $this->getBounceRateAction = $getBounceRateAction;
        $this->getButtonCountVisitorsAction = $getButtonCountVisitorsAction;
        $this->getVisitorsByParameterAction = $getVisitorsByParameterAction;
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

    public function getNewVisitorsCountForFilterData(GetNewVisitorCountFilterHttpRequest $request, GetNewestCountAction $action): ApiResponse
    {
        $response = $action->execute(GetNewestCountRequest::fromRequest($request));
        return ApiResponse::success(new VisitorCountResource($response->getCount()));
    }

    public function getNewVisitorsByDateRange(GetNewChartVisitorsHttpRequest $request): ApiResponse
    {
        $response = $this->getNewVisitorsByDateRangeAction->execute(
            GetNewChartVisitorsByDateRangeRequest::fromRequest($request));

        return ApiResponse::success(new ChartNewVisitorResourceCollection($response->getVisitorsByDateRange()));
    }

    public function getBounceRate(GetBounceRateHttpRequest $request): ApiResponse
    {
        $response = $this->getBounceRateAction->execute(
            GetBounceRateRequest::fromRequest($request)
        );

        return ApiResponse::success(new BounceRateResource($response));
    }

    public function getVisitorsByParameter(GetTableVisitorsByParameterHttpRequest $request): ApiResponse
    {
        $response = $this->getVisitorsByParameterAction->execute(
            GetVisitorsByParameterRequest::fromRequest($request));

        return ApiResponse::success(new TableVisitorsResourseCollection($response->visitors()));
    }

    public function getVisitorsCount(GetButtonCountVisitorsHttpRequest $request):ApiResponse
    {
        $response = $this->getButtonCountVisitorsAction->execute(GetButtonCountVisitorsRequest::fromRequest($request));
        return ApiResponse::success(new ButtonResource($response));
    }
}
