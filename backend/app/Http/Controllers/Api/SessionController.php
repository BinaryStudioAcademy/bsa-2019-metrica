<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Actions\Sessions\GetAvgSessionTimeByParameterAction;
use App\Actions\Sessions\GetAvgSessionTimeByParameterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetAvgSessionsTimeByParameterHttpRequest;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Resources\TableSessionResource;
use App\Http\Response\ApiResponse;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $getAvgSessionsTimeByParameterAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        GetAvgSessionTimeByParameterAction $getAvgSessionsTimeByParameterAction
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
        $response = $this->getAvgSessionsTimeByParameterAction->execute(
            GetAvgSessionTimeByParameterRequest::fromRequest($request)
        );

        return ApiResponse::success(new TableSessionResource($response->tableSessionCollection()));
    }
}
