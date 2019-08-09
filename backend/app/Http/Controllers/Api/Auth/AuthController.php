<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\GetCurrentUserAction;
use App\Actions\User\RegisterRequest;
use App\Actions\User\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterHttpRequest;
use App\Actions\Auth\AuthenticatedUserAction;
use App\Actions\Auth\AuthenticatedUserRequest;
use App\Contracts\ApiException;
use App\Http\Requests\AuthenticatedHttpRequest;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiResponse;
use App\Http\Response\RegistrationResponse;
use App\Http\Response\GetCurrentUserResponse;

final class AuthController extends Controller
{
    private $getCurrentUserAction;
    private $registerUserAction;

    public function __construct(
        GetCurrentUserAction $getCurrentUserAction,
        RegisterUserAction $registerUserAction
    ) {
        $this->getCurrentUserAction = $getCurrentUserAction;
        $this->registerUserAction = $registerUserAction;
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

    public function register(RegisterHttpRequest $request): ApiResponse
    {
        $request = RegisterRequest::fromHttpRequest($request);
        $response = $this->registerUserAction->execute($request);
        $token = $response->getToken();

        return ApiResponse::success(new RegistrationResponse(['token' => $token]));
    }

    public function getCurrentUser(): ApiResponse
    {
        $response = $this->getCurrentUserAction->execute();
        return ApiResponse::success(
            new GetCurrentUserResponse([
                new UserResource($response->user())
            ])
        );

    }
}
