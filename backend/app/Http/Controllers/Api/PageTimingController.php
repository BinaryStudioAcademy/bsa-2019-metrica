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

final class PageTimingController extends Controller
{
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
}
