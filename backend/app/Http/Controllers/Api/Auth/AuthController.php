<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\GetCurrentUserAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Request\Api\Auth\LoginHttpRequest;
use App\Http\Resources\LoginResources;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    private $getAuthenticatedUserAction;

    public function __construct(GetCurrentUserAction $getAuthenticatedUserAction)
    {
        $this->getAuthenticatedUserAction = $getAuthenticatedUserAction;
    }

    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action
    )
    {
        $response = $action->execute(LoginRequest::fromRequest($httpRequest));
        return ApiResponse::success(new LoginResources($response));

    }

    public function getCurrentUser(): JsonResponse
    {
        $response = $this->getAuthenticatedUserAction->execute();
        return response()->json(new UserResource($response->user()));
    }
}
