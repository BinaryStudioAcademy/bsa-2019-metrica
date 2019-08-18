<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Actions\Sessions\GetSessionsAction;
use App\Actions\Sessions\GetSessionsRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Resources\GetSessionsResource;
use App\Http\Requests\Api\GetSessionsFilterHttpRequest;
use App\Http\Response\ApiResponse;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $getSessionsAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        GetSessionsAction $getSessionsAction
    )
    {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->getSessionsAction = $getSessionsAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getSessions(GetSessionsFilterHttpRequest $request): ApiResponse
    {
        $response = $this->getSessionsAction->execute(
            GetSessionsRequest::fromHttpRequest($request)
        );

        return ApiResponse::success(new GetSessionsResource($response->sessions()));
    }
}
