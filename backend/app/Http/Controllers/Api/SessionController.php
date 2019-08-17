<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Actions\Sessions\GetAvgSessionsTimeByParameterAction;
use App\Actions\Sessions\GetAvgSessionsTimeByParameterRequest;
use App\Entities\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetAvgSessionsTimeByParameterHttpRequest;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Resources\TableSessionResource;
use App\Http\Resources\TableSessionResourceCollection;
use App\Http\Response\ApiResponse;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $getAvgSessionsTimeByParameterAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        GetAvgSessionsTimeByParameterAction $getAvgSessionsTimeByParameterAction
    ) {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->getAvgSessionsTimeByParameterAction = $getAvgSessionsTimeByParameterAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getAvgSessionsTimeByParameter(GetAvgSessionsTimeByParameterHttpRequest $request)
    {
        /*$response = $this->getAvgSessionsTimeByParameterAction->execute(
            GetAvgSessionsTimeByParameterRequest::fromRequest($request)
        );

        return ApiResponse::success(new TableSessionResourceCollection($response->avgSessionsTimeCollection()));*/
        return new TableSessionResource(Session::first());
    }
}
