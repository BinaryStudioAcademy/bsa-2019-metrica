<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Response\ApiResponse;
use App\Http\Resources\CountSessions;
use App\Http\Requests\Api\CountSessionsHttpRequest;
use App\Actions\Sessions\CountSessionsAction;
use App\Actions\Sessions\CountSessionsRequest;
use App\Http\Resources\AvgSession;
use App\Actions\Sessions\GetAvgSessionAction;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Http\Requests\Api\GetAvgSessionHttpRequest;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $countSessionsAction;
    private $getAvgSessionAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        CountSessionsAction $countSessionsAction,
        GetAvgSessionAction $getAvgSessionAction
    ) {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->countSessionsAction = $countSessionsAction;
        $this->getAvgSessionAction = $getAvgSessionAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getCountOfSessions(CountSessionsHttpRequest $request): ApiResponse
    {
        $response = $this->countSessionsAction->execute(
            CountSessionsRequest::fromHttpRequest($request)
        );

        return ApiResponse::success(new CountSessions($response->countSessions()));
    }

    public function getAverageSession(GetAvgSessionHttpRequest $request): ApiResponse
    {
        $response = $this->getAvgSessionAction->execute(
            new GetAvgSessionRequest($request->startDate(), $request->endDate())
        );
        return ApiResponse::success(new AvgSession($response->avgSession()));
    }
}
