<?php


namespace App\Http\Controllers\Api;


use App\Actions\PageTimings\GetPageLoadingChartAction;
use App\Actions\PageTimings\GetPageLoadingChartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\FilterByPeriodHttpRequest;
use App\Http\Requests\PageTimings\PageLoadingChartHttpRequest;
use App\Http\Resources\ButtonResource;
use App\Http\Resources\ChartResource;
use App\Http\Response\ApiResponse;
use App\Actions\PageTimings\{GetAverageTimingAction, GetAverageTimingRequest};

final class PageTimingController extends Controller
{
    private $getAveragePageLoadTimeAction;

    public function __construct(
        GetAverageTimingAction $getAveragePageLoadTimeAction
    ) {
        $this->getAveragePageLoadTimeAction = $getAveragePageLoadTimeAction;
    }
    /*
    public function getPageLoadingChartData(PageLoadingChartHttpRequest $request, GetPageLoadingChartAction $action)
    {
        $response = $action->execute(GetPageLoadingChartRequest::fromRequest($request));
        return ApiResponse::success(new ChartResource($response->getCollection()));
    }*/

    public function getAveragePageLoading(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAveragePageLoadTimeAction->execute(
            GetAverageTimingRequest::fromRequest($request),
            'page_load_time'
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAverageDomainLookupTime(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAveragePageLoadTimeAction->execute(
            GetAverageTimingRequest::fromRequest($request),
            'domain_lookup_time'
        );
        return ApiResponse::success(new ButtonResource($average));
    }

    public function getAverageServerResponseTime(FilterByPeriodHttpRequest $request): ApiResponse
    {
        $average = $this->getAveragePageLoadTimeAction->execute(
            GetAverageTimingRequest::fromRequest($request),
            'server_response_time'
        );
        return ApiResponse::success(new ButtonResource($average));
    }
}
