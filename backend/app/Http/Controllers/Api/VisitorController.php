<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Visitors\GetAllVisitorsAction;
use App\Actions\Visitors\GetNewVisitorsAction;
use App\Actions\Visitors\GetVisitorsByParameterAction;
use App\Actions\Visitors\GetVisitorsByParameterRequest;
use App\Http\Requests\Api\GetVisitorsByParameterHttpRequest;
use App\Http\Resources\VisitorResourceCollection;
use App\Http\Resources\TableVisitorsResourse;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;

final class VisitorController extends Controller
{
    private $getAllVisitorsAction;
    private $getNewVisitorsAction;
    private $getVisitorsByParameterAction;

    public function __construct(
        GetAllVisitorsAction $getAllVisitorsAction,
        GetNewVisitorsAction $getNewVisitorsAction,
        GetVisitorsByParameterAction $getVisitorsByParameterAction
    )
    {
        $this->getAllVisitorsAction = $getAllVisitorsAction;
        $this->getNewVisitorsAction = $getNewVisitorsAction;
        $this->getVisitorsByParameterAction = $getVisitorsByParameterAction;
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

    public function getVisitorsByParameter (GetVisitorsByParameterHttpRequest $request): ApiResponse
    {
        $response = $this->getVisitorsByParameterAction->execute(
            GetVisitorsByParameterRequest::fromRequest($request));

        return ApiResponse::success(new TableVisitorsResourse($response->visitors()));
    }
}
