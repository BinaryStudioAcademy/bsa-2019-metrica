<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visits\GetPageViewsByParameterAction;
use App\Actions\Visits\GetPageViewsByParameterRequest;
use App\Actions\Visits\GetPageViewsRequest;
use App\Actions\Visits\GetPageViewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPageViewsFilterHttpRequest;
use App\Http\Requests\Api\GetTableVisitsByParameterHttpRequest;
use App\Http\Resources\TableVisitsResourceCollection;
use App\Http\Resources\VisitResource;
use App\Http\Response\ApiResponse;

final class VisitController extends Controller
{
    private $getPageViewsAction;
    private $getPageViewsByParameterAction;

    public function __construct(
        GetPageViewsAction $getPageViewsAction,
        GetPageViewsByParameterAction $getPageViewsByParameterAction
    ) {
        $this->getPageViewsAction = $getPageViewsAction;
        $this->getPageViewsByParameterAction = $getPageViewsByParameterAction;
    }

    public function getPageViews(GetPageViewsFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsAction->execute(GetPageViewsRequest::fromRequest($request));

        return ApiResponse::success(new VisitResource($response->views()));
    }

    public function getPageViewsByParameter(GetTableVisitsByParameterHttpRequest $request): ApiResponse
    {
        $response = $this->getPageViewsByParameterAction
            ->execute(GetPageViewsByParameterRequest::fromRequest($request));

        return ApiResponse::success(new TableVisitsResourceCollection($response->visits()));
    }
}
