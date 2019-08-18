<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Actions\Sessions\GetAvgSessionAction;
use App\Actions\Sessions\GetAvgSessionTimeByParameterAction;
use App\Actions\Sessions\GetAvgSessionTimeByParameterRequest;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Http\Resources\AvgSession;
use App\Http\Requests\Api\GetAvgSessionsTimeByParameterHttpRequest;
use App\Http\Requests\Api\GetAvgSessionHttpRequest;
use App\Http\Resources\TableSessionResource;
use App\Http\Resources\SessionResourceCollection;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $getAvgSessionAction;
    private $getAvgSessionTimeByParameterAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        GetAvgSessionAction $getAvgSessionAction,
        GetAvgSessionTimeByParameterAction $getAvgSessionTimeByParameterAction
    ) {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->getAvgSessionAction = $getAvgSessionAction;
        $this->getAvgSessionTimeByParameterAction = $getAvgSessionTimeByParameterAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getAverageSession(GetAvgSessionHttpRequest $request): ApiResponse
    {
        $response = $this->getAvgSessionAction->execute(
            new GetAvgSessionRequest($request->startDate(), $request->endDate())
        );
        return ApiResponse::success(new AvgSession($response->avgSession()));
    }

    public function getAvgSessionTimeByParameter(GetAvgSessionsTimeByParameterHttpRequest $request)
    {
        $response = $this->getAvgSessionTimeByParameterAction->execute(
            GetAvgSessionTimeByParameterRequest::fromRequest($request)
        );

        return ApiResponse::success(new TableSessionResource($response->tableSessionCollection()));
    }
}
