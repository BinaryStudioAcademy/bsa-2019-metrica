<?php


namespace App\Http\Controllers\Api;


use App\Actions\PageTimings\GetPageLoadingChartAction;
use App\Actions\PageTimings\GetPageLoadingChartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageTimings\PageLoadingChartHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Response\ApiResponse;

final class PageTimingController extends Controller
{
    public function getPageLoadingChartData(PageLoadingChartHttpRequest $request, GetPageLoadingChartAction $action)
    {
        $response = $action->execute(GetPageLoadingChartRequest::fromRequest($request));
        return ApiResponse::success(new ChartResource($response->getCollection()));
    }
}
