<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visits\GetPageViewsByParameterAction;
use App\Actions\Visits\GetPageViewsByParameterRequest;
use App\Actions\Visits\GetPageViewsCountAction;
use App\Actions\Visits\GetPageViewsCountRequest;
use App\Actions\Visits\CreateVisitAction;
use App\Actions\Visits\CreateVisitRequest;
use App\Actions\Visits\GetPageViewsRequest;
use App\Actions\Visits\GetPageViewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Visit\CreateVisitHttpRequest;
use App\Http\Requests\Visit\GetPageViewsFilterHttpRequest;
use App\Http\Resources\ChartResource;
use App\Http\Requests\Api\GetPageViewsCountFilterHttpRequest;
use App\Http\Requests\Api\GetPageViewsFilterHttpRequest;
use App\Http\Requests\Api\GetTableVisitsByParameterHttpRequest;
use App\Http\Resources\TableResource;
use App\Http\Resources\VisitCountResource;
use App\Http\Resources\VisitResource;
use App\Http\Response\ApiResponse;

final class VisitController extends Controller
{
    private $getPageViewsAction;
    private $getPageViewsByParameterAction;
    private $getPageViewsCountAction;
    private $createVisitAction;

    public function __construct(
        GetPageViewsAction $getPageViewsAction,
        GetPageViewsByParameterAction $getPageViewsByParameterAction,
        GetPageViewsCountAction $getPageViewsCountAction,
        CreateVisitAction $createVisitAction
    ) {
        $this->getPageViewsAction = $getPageViewsAction;
        $this->getPageViewsByParameterAction = $getPageViewsByParameterAction;
        $this->getPageViewsCountAction = $getPageViewsCountAction;
        $this->createVisitAction = $createVisitAction;
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
        return ApiResponse::success(new VisitCountResource($response->getCount()));
    }

    public function createVisit(CreateVisitHttpRequest $request): ApiResponse
    {
        $response = $this->createVisitAction->execute(CreateVisitRequest::fromRequest($request));

        return ApiResponse::success(new VisitResource($response->visit()));
    }
}
