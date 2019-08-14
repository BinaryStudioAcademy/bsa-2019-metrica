<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Actions\Sessions\GetSessionsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResourceCollection;
use App\Http\Response\ApiResponse;

final class SessionController extends Controller
{
    private $getAllSessionsAction;

    public function __construct(GetAllSessionsAction $getAllSessionsAction)
    {
        $this->getAllSessionsAction = $getAllSessionsAction;
    }

    public function getAllSessions(): ApiResponse
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }

    public function getSessions(): ApiResponse
    {
        $response = $this->getSessionsAction->execute();

        return ApiResponse::success(new SessionResourceCollection($response->sessions()));
    }
}
