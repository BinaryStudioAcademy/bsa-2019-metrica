<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visits\GetPageViewsCountAction;
use App\Actions\Visits\GetPageViewsCountRequest;
use App\Actions\Visits\GetPageViewsRequest;
use App\Actions\Visits\GetPageViewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPageViewsCountFilterHttpRequest;
use App\Http\Requests\Api\GetPageViewsFilterHttpRequest;
use App\Http\Resources\VisitCountResource;
use App\Http\Resources\VisitResource;
use App\Http\Response\ApiResponse;

final class VisitController extends Controller
{
    private $getPageViewsAction;
    private $getPageViewsCountAction;

    public function __construct(
        GetPageViewsAction $getPageViewsAction,
        GetPageViewsCountAction $getPageViewsCountAction
    )
    {
        $this->getPageViewsAction = $getPageViewsAction;
        $this->getPageViewsCountAction = $getPageViewsCountAction;
    }

    public function getPageViews(GetPageViewsFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsAction->execute(GetPageViewsRequest::fromRequest($request));

        return ApiResponse::success(new VisitResource($response->views()));
    }

    public function getPageViewsCountForFilterData(GetPageViewsCountFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsCountAction->execute(GetPageViewsCountRequest::fromRequest($request));
        return ApiResponse::success(new VisitCountResource($response->getCount()));
    }
}
