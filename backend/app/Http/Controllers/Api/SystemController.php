<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\FilterByPeriodHttpRequest;
use App\Http\Resources\MostPopularWidgetResource;
use App\Http\Response\ApiResponse;
use App\Actions\System\{GetMostPopularOsAction, GetMostPopularOsRequest,
    GetDeviceTypeStatsAction, GetDeviceTypeStatsRequest};

final class SystemController extends Controller
{
    private $getMostPopularOsAction;
    private $getDeviceTypeStatsAction;

    public function __construct(
        GetMostPopularOsAction $getMostPopularOsAction,
        GetDeviceTypeStatsAction $getDeviceTypeStatsAction
    ) {
        $this->getMostPopularOsAction = $getMostPopularOsAction;
        $this->getDeviceTypeStatsAction = $getDeviceTypeStatsAction;
    }

    public function getMostPopularOs(FilterByPeriodHttpRequest $request)
    {
        $response = $this->getMostPopularOsAction->execute(
            GetMostPopularOsRequest::fromRequest($request)
        );

        return ApiResponse::success(
            new MostPopularWidgetResource(
                $response->getMostPopularSystems()
            )
        );
    }

    public function getStats(FilterByPeriodHttpRequest $request)
    {
        $response = $this->getDeviceTypeStatsAction->execute(
            GetDeviceTypeStatsRequest::fromRequest($request)
        );

        return ApiResponse::success(
            new MostPopularWidgetResource(
                $response->getDevicesStats()
            )
        );
    }
}
