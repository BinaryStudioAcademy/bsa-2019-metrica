<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\GetCurrentUserAction;
use App\Actions\Auth\AuthenticatedUserAction;
use App\Actions\Auth\AuthenticatedUserRequest;
use App\Contracts\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticatedHttpRequest;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\GetCurrentUserResponse;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    private $getAuthenticatedUserAction;

    public function __construct(GetCurrentUserAction $getAuthenticatedUserAction)
    {
        $this->getAuthenticatedUserAction = $getAuthenticatedUserAction;
    }

    public function login(
        AuthenticatedHttpRequest $request,
        AuthenticatedUserAction $action
    ): ApiResponse
    {
        try {
            $response = $action->execute(AuthenticatedUserRequest::fromRequest($request));
        } catch (ApiException $exception) {
            return ApiResponse::error($exception);
        }
        return ApiResponse::success($response);

    }

    public function getCurrentUser(): JsonResponse
    {
        $response = $this->getAuthenticatedUserAction->execute();
        return ApiResponse::success(
            new GetCurrentUserResponse([
                new UserResource($response->user())
            ])
        );
    }
}
