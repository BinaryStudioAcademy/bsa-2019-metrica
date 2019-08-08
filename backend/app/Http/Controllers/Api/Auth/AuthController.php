<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\GetCurrentUserAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LoginRequest;
use app\Actions\User\RegisterRequest;
use App\Actions\User\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Request\Api\Auth\LoginHttpRequest;
use App\Http\Requests\RegisterHttpRequest;
use App\Http\Resources\LoginResources;
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
        LoginHttpRequest $httpRequest,
        LoginAction $action
    ) {
        $response = $action->execute(LoginRequest::fromRequest($httpRequest));
        return ApiResponse::success(new LoginResources($response));

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
