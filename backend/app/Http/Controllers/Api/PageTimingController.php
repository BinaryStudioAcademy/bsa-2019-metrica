<?php


namespace App\Http\Controllers\Api;

use App\Actions\PageTimings\GetDomainLookupChartAction;
use App\Actions\PageTimings\GetPageLoadingChartAction;
use App\Actions\PageTimings\GetChartRequest;
use App\Actions\PageTimings\GetServerResponseChartAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageTimings\PageTimingChartHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Response\ApiResponse;
use App\Actions\PageTimings\GetAverageTimingAction;
use App\Http\Requests\System\FilterByPeriodHttpRequest;
use App\Http\Resources\ButtonResource;
use App\Actions\PageTimings\GetAverageTimingRequest;

final class PageTimingController extends Controller
{
    private $getAveragePageLoadTimeAction;

    public function __construct(
        GetAverageTimingAction $getAveragePageLoadTimeAction
    ) {
        $this->getAveragePageLoadTimeAction = $getAveragePageLoadTimeAction;
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
        $average = $this->getAveragePageLoadTimeAction->execute(
            new GetAverageTimingRequest($request, 'page_load_time', $request->websiteId())
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAverageDomainLookupTime(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAveragePageLoadTimeAction->execute(
            new GetAverageTimingRequest($request, 'domain_lookup_time', $request->websiteId())
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAverageServerResponseTime(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAveragePageLoadTimeAction->execute(
            new GetAverageTimingRequest($request, 'server_response_time', $request->websiteId())
        );
        return ApiResponse::success(new ButtonResource($average));
    }
}
