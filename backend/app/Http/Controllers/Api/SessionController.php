<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Sessions\GetAllSessionsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionResource;
use App\Http\Response\Sessions\GetAllSessionsResponse;
use App\Http\Response\ApiResponse;

final class SessionController extends Controller
{
    private $getAllSessionsAction;

    public function __construct(GetAllSessionsAction $getAllSessionsAction)
    {
        $this->getAllSessionsAction = $getAllSessionsAction;
    }

    public function getAllSessions()
    {
        $response = $this->getAllSessionsAction->execute();

        return ApiResponse::success(
            new GetAllSessionsResponse([
                'sessions' => SessionResource::collection($response->sessions())
            ])
        );
    }
}
