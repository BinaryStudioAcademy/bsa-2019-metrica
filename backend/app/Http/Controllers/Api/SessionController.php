<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Response\ApiResponse;
use App\Http\Resources\AvgSession;
use App\Actions\Sessions\GetAvgSessionAction;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Http\Requests\Api\GetAvgSessionHttpRequest;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $getAvgSessionAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        GetAvgSessionAction $getAvgSessionAction
    ) {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->getAvgSessionAction = $getAvgSessionAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getAverageSession(GetAvgSessionHttpRequest $request): ApiResponse
    {
        $response = $this->getAvgSessionAction->execute(
            GetAvgSessionRequest::fromHttpRequest($request)
        );
        return ApiResponse::success(new AvgSession($response->avgSession()));
    }
}
