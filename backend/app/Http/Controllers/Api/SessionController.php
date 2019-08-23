<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Actions\Sessions\GetSessionsAction;
use App\Actions\Sessions\GetSessionsRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ButtonResource;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Resources\ChartResource;
use App\Http\Requests\Session\GetSessionsFilterHttpRequest;
use App\Actions\Sessions\GetAvgSessionAction;
use App\Actions\Sessions\GetAvgSessionTimeByParameterAction;
use App\Actions\Sessions\GetAvgSessionTimeByParameterRequest;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Http\Response\ApiResponse;
use App\Http\Requests\Session\CountSessionsHttpRequest;
use App\Actions\Sessions\CountSessionsAction;
use App\Actions\Sessions\CountSessionsRequest;
use App\Actions\Sessions\GetSessionsByParameterAction;
use App\Actions\Sessions\GetSessionsByParameterRequest;
use App\Http\Requests\Session\GetSessionsByParameterHttpRequest;
use App\Http\Requests\Session\GetAvgSessionsTimeByParameterHttpRequest;
use App\Http\Requests\Session\GetAvgSessionHttpRequest;
use App\Http\Resources\TableSessionResource;
use App\Http\Resources\TableResource;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $getSessionsAction;
    private $countSessionsAction;
    private $getAvgSessionAction;
    private $getAvgSessionTimeByParameterAction;
    private $getSessionsByParameterAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        GetSessionsAction $getSessionsAction,
        CountSessionsAction $countSessionsAction,
        GetAvgSessionAction $getAvgSessionAction,
        GetAvgSessionTimeByParameterAction $getAvgSessionTimeByParameterAction,
        GetSessionsByParameterAction $getSessionsByParameterAction
    ) {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->getSessionsAction = $getSessionsAction;
        $this->countSessionsAction = $countSessionsAction;
        $this->getAvgSessionAction = $getAvgSessionAction;
        $this->getAvgSessionTimeByParameterAction = $getAvgSessionTimeByParameterAction;
        $this->getSessionsByParameterAction = $getSessionsByParameterAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getSessions(GetSessionsFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getSessionsAction->execute(
            GetSessionsRequest::fromRequest($request)
        );

        return ApiResponse::success(new ChartResource($response->sessions()));
    }

    public function getCountOfSessions(CountSessionsHttpRequest $request): ApiResponse
    {
        $response = $this->countSessionsAction->execute(
            new CountSessionsRequest($request->startDate(), $request->endDate())
        );

        return ApiResponse::success(new ButtonResource($response));
    }

    public function getAverageSession(GetAvgSessionHttpRequest $request): ApiResponse
    {
        $response = $this->getAvgSessionAction->execute(
            new GetAvgSessionRequest($request->startDate(), $request->endDate())
        );
        return ApiResponse::success(new ButtonResource($response));
    }

    public function getAvgSessionTimeByParameter(GetAvgSessionsTimeByParameterHttpRequest $request)
    {
        $response = $this->getAvgSessionTimeByParameterAction->execute(
            GetAvgSessionTimeByParameterRequest::fromRequest($request)
        );

        return ApiResponse::success(new TableSessionResource($response->tableSessionCollection()));
    }

    public function getSessionsByParameter(
        GetSessionsByParameterHttpRequest $request
    ) {
        $response = $this->getSessionsByParameterAction->execute(
            GetSessionsByParameterRequest::fromRequest($request)
        );

        return ApiResponse::success(
            new TableResource($response->getSessionsByParameter())
        );
    }
}
