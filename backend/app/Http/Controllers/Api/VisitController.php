<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visits\GetBounceRateChartByDateRangeAction;
use App\Actions\Visits\GetBounceRateChartByDateRangeRequest;
use App\Actions\Visits\GetBounceRatePageViewsButtonAction;
use App\Actions\Visits\GetBounceRatePageViewsButtonRequest;
use App\Actions\Visits\GetUniquePageViewsButtonAction;
use App\Actions\Visits\GetUniquePageViewsButtonRequest;
use App\Http\Requests\Api\GetBounceRateChartHttpRequest;
use App\Http\Requests\Visit\GetBouncePageViewsHttpRequest;
use App\Http\Requests\Visit\GetPageViewsFilterHttpRequest;
use App\Actions\Visits\GetPageViewsByParameterAction;
use App\Actions\Visits\GetPageViewsByParameterRequest;
use App\Actions\Visits\GetPageViewsCountAction;
use App\Actions\Visits\GetPageViewsCountRequest;
use App\Actions\Visits\CreateVisitAction;
use App\Actions\Visits\GetPageViewsItemsAction;
use App\Actions\Visits\GetPageViewsItemsRequest;
use App\Actions\Visits\GetPageViewsRequest;
use App\Actions\Visits\GetPageViewsAction;
use App\Actions\Visits\GetUniquePageViewsChartAction;
use App\Actions\Visits\GetUniquePageViewsChartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Visit\TablePageViewsHttpRequest;
use App\Http\Requests\Visit\GetUniquePageViewsButtonHttpRequest;
use App\Http\Requests\Visit\GetUniquePageViewsChartHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Requests\Visit\GetPageViewsCountFilterHttpRequest;
use App\Http\Requests\Visit\GetTableVisitsByParameterHttpRequest;
use App\Http\Resources\ButtonResource;
use App\Http\Resources\TablePageViewsResource;
use App\Http\Resources\TableResource;
use App\Http\Response\ApiResponse;
use App\Http\Requests\Visit\GetPageViewsAvgTimeHttpRequest;
use App\Actions\Visits\GetPageViewsAvgTimeRequest;
use App\Actions\Visits\GetPageViewsAvgTimeAction;
use App\Actions\Visits\GetPageViewsChartAvgTimeAction;
use App\Http\Requests\Visit\GetPageViewsChartAvgTimeHttpRequest;
use App\Actions\Visits\GetPageViewsChartAvgTimeRequest;

final class VisitController extends Controller
{
    private $getPageViewsAction;
    private $getPageViewsByParameterAction;
    private $getPageViewsCountAction;
    private $createVisitAction;
    private $getPageViewsItemsAction;
    private $getUniquePageViewsButtonAction;
    private $getUniquePageViewChartAction;
    private $getChartBounceRateAction;
    private $getPageViewsAvgTimeAction;
    private $getBounceRatePageViewsButtonAction;
    private $getPageViewsChartAvgTimeAction;

    public function __construct(
        GetPageViewsAction $getPageViewsAction,
        GetPageViewsByParameterAction $getPageViewsByParameterAction,
        GetPageViewsCountAction $getPageViewsCountAction,
        CreateVisitAction $createVisitAction,
        GetPageViewsItemsAction $getPageViewsItemsAction,
        GetUniquePageViewsButtonAction $getUniquePageViewsButtonAction,
        GetUniquePageViewsChartAction $getUniquePageViewChartAction,
        GetBounceRateChartByDateRangeAction $getChartBounceRateAction,
        GetBounceRatePageViewsButtonAction $getBounceRatePageViewsButtonAction,
        GetPageViewsAvgTimeAction $getPageViewsAvgTimeAction,
        GetPageViewsChartAvgTimeAction $getPageViewsChartAvgTimeAction
    ) {
        $this->getPageViewsAction = $getPageViewsAction;
        $this->getPageViewsByParameterAction = $getPageViewsByParameterAction;
        $this->getPageViewsCountAction = $getPageViewsCountAction;
        $this->createVisitAction = $createVisitAction;
        $this->getPageViewsItemsAction = $getPageViewsItemsAction;
        $this->getUniquePageViewsButtonAction = $getUniquePageViewsButtonAction;
        $this->getUniquePageViewChartAction = $getUniquePageViewChartAction;
        $this->getChartBounceRateAction = $getChartBounceRateAction;
        $this->getPageViewsAvgTimeAction = $getPageViewsAvgTimeAction;
        $this->getBounceRatePageViewsButtonAction = $getBounceRatePageViewsButtonAction;
        $this->getPageViewsChartAvgTimeAction = $getPageViewsChartAvgTimeAction;
    }

    public function getPageViews(GetPageViewsFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsAction->execute(GetPageViewsRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->views()));
    }

    public function getPageViewsByParameter(GetTableVisitsByParameterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsByParameterAction
            ->execute(GetPageViewsByParameterRequest::fromRequest($request));

        return ApiResponse::success(new TableResource($response->visits()));
    }

    public function getPageViewsCountForFilterData(GetPageViewsCountFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsCountAction->execute(GetPageViewsCountRequest::fromRequest($request));
        return ApiResponse::success(new ButtonResource($response));
    }

    public function getPageViewsItems(TablePageViewsHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsItemsAction->execute(
            new GetPageViewsItemsRequest(
                $request->startDate(),
                $request->endDate(),
                $request->websiteId()
            )
        )->items();

        return ApiResponse::success(new TablePageViewsResource($response));
    }

    public function getChartBounceRate(GetBounceRateChartHttpRequest $request): ApiResponse
    {
        $response = $this->getChartBounceRateAction->execute(GetBounceRateChartByDateRangeRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->getVisitsBounceRateCollection()));
    }

    public function getUniquePageViewsButton(GetUniquePageViewsButtonHttpRequest $request): ApiResponse
    {
        $response = $this->getUniquePageViewsButtonAction->execute(GetUniquePageViewsButtonRequest::fromRequest($request));
        return ApiResponse::success(new ButtonResource($response));
    }

    public function getPageViewsAvgTimeForFilterData(GetPageViewsAvgTimeHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsAvgTimeAction->execute(GetPageViewsAvgTimeRequest::fromRequest($request));
        return ApiResponse::success(new ButtonResource($response));
    }

    public function getUniquePageViewsChart(GetUniquePageViewsChartHttpRequest $request): ApiResponse
    {
        $response = $this->getUniquePageViewChartAction->execute(GetUniquePageViewsChartRequest::fromRequest($request));
        return ApiResponse::success(new ChartResource($response->getUniquePageViewsCollection()));
    }

    public function getPageViewsBounceRateForFilterData(GetBouncePageViewsHttpRequest $request): ApiResponse
    {
        $response = $this->getBounceRatePageViewsButtonAction->execute(
            GetBounceRatePageViewsButtonRequest::fromRequest($request)
        );

        return ApiResponse::success(new ButtonResource($response));
    }

    public function getPageViewsChartAvgTimeForFilterData(GetPageViewsChartAvgTimeHttpRequest $request)
    {
        $response = $this->getPageViewsChartAvgTimeAction->execute(GetPageViewsChartAvgTimeRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->chartData()));
    }
}
