<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Response\ApiResponse;
use App\Http\Resources\CountSession;
use App\Http\Requests\Api\CountSessionsHttpRequest;
use App\Actions\Sessions\CountSessionsAction;
use App\Actions\Sessions\CountSessionsRequest;

final class SessionController extends Controller
{
    private $getAllSessionsAction;
    private $countSessionsAction;

    public function __construct(
        GetAllSessionsAction $getAllSessionsAction,
        CountSessionsAction $countSessionsAction
    )
    {
        $this->getAllSessionsAction = $getAllSessionsAction;
        $this->countSessionsAction = $countSessionsAction;
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

        return ApiResponse::success(new CountSession($response->countSessions()));
    }
}
