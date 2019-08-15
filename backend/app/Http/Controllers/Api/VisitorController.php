<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visitors\GetAllVisitorsAction;
use App\Actions\Visitors\GetNewestCountAction;
use App\Actions\Visitors\GetNewestCountRequest;
use App\Actions\Visitors\GetNewVisitorsAction;
use App\Actions\Visitors\GetNewVisitorsByDateRangeAction;
use App\Actions\Visitors\GetNewVisitorsByDateRangeRequest;
use App\Http\Requests\Visitors\GetNewVisitorCountFilterHttpHttpRequest;
use App\Http\Requests\Visitors\GetNewVisitorsHttpRequest;
use App\Http\Resources\VisitorCountResource;
use App\Http\Resources\VisitorResourceCollection;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;

final class VisitorController extends Controller
{
    private $getAllVisitorsAction;
    private $getNewVisitorsAction;
    private $getNewVisitorsByDateRangeAction;

    public function __construct(
        GetAllVisitorsAction $getAllVisitorsAction,
        GetNewVisitorsAction $getNewVisitorsAction,
        GetNewVisitorsByDateRangeAction $getNewVisitorsByDateRangeAction
    )
    {
        $this->getAllVisitorsAction = $getAllVisitorsAction;
        $this->getNewVisitorsAction = $getNewVisitorsAction;
        $this->getNewVisitorsByDateRangeAction = $getNewVisitorsByDateRangeAction;
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

    public function getNewVisitorsByDateRange(GetNewVisitorsHttpRequest $request)
    {
        $response = $this->getNewVisitorsByDateRangeAction->execute(GetNewVisitorsByDateRangeRequest::fromRequest($request));
        return response()->json(['data'=>$response]);
    }
}
