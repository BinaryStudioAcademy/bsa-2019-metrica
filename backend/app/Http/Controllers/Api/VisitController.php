<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visits\CreateVisitAction;
use App\Actions\Visits\CreateVisitRequest;
use App\Actions\Visits\GetPageViewsRequest;
use App\Actions\Visits\GetPageViewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Visit\CreateVisitHttpRequest;
use App\Http\Requests\Visit\GetPageViewsFilterHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Resources\VisitResource;
use App\Http\Response\ApiResponse;

final class VisitController extends Controller
{
    private $getPageViewsAction;
    private $createVisitAction;

    public function __construct(
        GetPageViewsAction $getPageViewsAction,
        CreateVisitAction $createVisitAction
    ) {
        $this->getPageViewsAction = $getPageViewsAction;
        $this->createVisitAction = $createVisitAction;
    }

    public function getPageViews(GetPageViewsFilterHttpRequest $request)
    {
        $response = $this->getPageViewsAction->execute(GetPageViewsRequest::fromRequest($request));

        return ApiResponse::success(new ChartResource($response->views()));
    }

    public function createVisit(CreateVisitHttpRequest $request): ApiResponse
    {
        $response = $this->createVisitAction->execute(CreateVisitRequest::fromRequest($request));

        return ApiResponse::success(new VisitResource($response->visit()));
    }
}
