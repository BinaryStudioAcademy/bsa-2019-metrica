<?php


namespace App\Http\Controllers\Api;

use App\Actions\PageTimings\GetAverageTimingByParamAction;
use App\Actions\PageTimings\GetAverageTimingByParamRequest;
use App\Actions\PageTimings\GetDomainLookupChartAction;
use App\Actions\PageTimings\GetPageLoadingChartAction;
use App\Actions\PageTimings\GetChartRequest;
use App\Actions\PageTimings\GetServerResponseChartAction;
use App\Http\Controllers\Controller;
use App\Http\Request\PageTimingTableHttpRequest;
use App\Http\Requests\PageTimings\PageTimingChartHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Resources\SpeedOverviewTableResource;
use App\Http\Response\ApiResponse;
use App\Actions\PageTimings\GetAverageTimingAction;
use App\Http\Requests\System\FilterByPeriodHttpRequest;
use App\Http\Resources\ButtonResource;
use App\Actions\PageTimings\GetAverageTimingRequest;

final class PageTimingController extends Controller
{
    private $getAverageTimingAction;
    private $getAverageTimingByParamAction;

    public function __construct(
        GetAverageTimingAction $getAveragePageLoadTimeAction,
        GetAverageTimingByParamAction $getAverageTimingByParamAction
    ) {
        $this->getAverageTimingAction = $getAveragePageLoadTimeAction;
        $this->getAverageTimingByParamAction = $getAverageTimingByParamAction;
    }

    public function getPageLoadingChartData(PageTimingChartHttpRequest $request, GetPageLoadingChartAction $action)
    {
        $response = $action->execute(GetChartRequest::fromRequest($request));
        return ApiResponse::success(new ChartResource($response->getCollection()));
    }

    public function getDomainLookupChartData(PageTimingChartHttpRequest $request, GetDomainLookupChartAction $action)
    {
        $response = $action->execute(GetChartRequest::fromRequest($request));
        return ApiResponse::success(new ChartResource($response->getCollection()));
    }

    public function getServerResponseChartData(PageTimingChartHttpRequest $request, GetServerResponseChartAction $action)
    {
        $response = $action->execute(GetChartRequest::fromRequest($request));
        return ApiResponse::success(new ChartResource($response->getCollection()));
    }

    public function getAveragePageLoading(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAverageTimingAction->execute(
            new GetAverageTimingRequest($request, 'page_load_time')
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAverageDomainLookupTime(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAverageTimingAction->execute(
            new GetAverageTimingRequest($request, 'domain_lookup_time')
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAverageServerResponseTime(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAverageTimingAction->execute(
            new GetAverageTimingRequest($request, 'server_response_time')
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAveragePageLoadingTimeForParam(PageTimingTableHttpRequest $request)
    {
        $results = $this->getAverageTimingByParamAction->execute(
            new GetAverageTimingByParamRequest($request, 'page_load_time')
        );
        return ApiResponse::success(new SpeedOverviewTableResource($results));
    }

    public function getAverageDomainLookupTimeForParam(PageTimingTableHttpRequest $request)
    {
        $results = $this->getAverageTimingByParamAction->execute(
            new GetAverageTimingByParamRequest($request, 'domain_lookup_time')
        );
        return ApiResponse::success(new SpeedOverviewTableResource($results));
    }

    public function getAverageServerResponseTimeForParam(PageTimingTableHttpRequest $request)
    {
        $results = $this->getAverageTimingByParamAction->execute(
            new GetAverageTimingByParamRequest($request, 'server_response_time')
        );
        return ApiResponse::success(new SpeedOverviewTableResource($results));
    }
}
