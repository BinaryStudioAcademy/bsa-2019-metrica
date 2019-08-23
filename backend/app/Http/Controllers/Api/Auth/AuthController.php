<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\AuthenticatedUserAction;
use App\Actions\Auth\AuthenticatedUserRequest;
use App\Actions\Auth\GetCurrentUserAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\RegisterRequest;
use App\Actions\Auth\SocialAuthenticationAction;
use App\Actions\Auth\SocialRedirectAction;
use App\Actions\Auth\SocialAuthRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticatedHttpRequest;
use App\Http\Requests\Auth\RegisterHttpRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UrlResource;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiResponse;

final class AuthController extends Controller
{
    private $authenticatedUserAction;
    private $getCurrentUserAction;
    private $registerUserAction;
    private $socialAuthRedirectAction;
    private $socialAuthenticationAction;

    public function __construct(
        AuthenticatedUserAction $authenticatedUserAction,
        GetCurrentUserAction $getCurrentUserAction,
        RegisterAction $registerUserAction,
        SocialRedirectAction $socialAuthRedirectAction,
        SocialAuthenticationAction $socialAuthenticationAction
    ) {
        $this->authenticatedUserAction = $authenticatedUserAction;
        $this->getCurrentUserAction = $getCurrentUserAction;
        $this->registerUserAction = $registerUserAction;
        $this->socialAuthRedirectAction = $socialAuthRedirectAction;
        $this->socialAuthenticationAction = $socialAuthenticationAction;
    }

    public function login(AuthenticatedHttpRequest $request): ApiResponse
    {
        $response = $this->authenticatedUserAction->execute(
            AuthenticatedUserRequest::fromRequest($request)
        );

        return ApiResponse::success(new TokenResource($response));
    }

    public function register(RegisterHttpRequest $request): ApiResponse
    {
        $request = RegisterRequest::fromHttpRequest($request);
        $response = $this->registerUserAction->execute($request);

        return ApiResponse::success(new TokenResource($response));
    }

    public function getCurrentUser(): ApiResponse
    {
        $response = $this->getCurrentUserAction->execute();
        return ApiResponse::success(new UserResource($response->user()));
    }

    public function redirect(string $provider)
    {
        $response = $this->socialAuthRedirectAction->execute(new SocialAuthRequest($provider));

        return ApiResponse::success(new UrlResource($response));
    }

    public function oauthCallback(string $provider)
    {
        $response = $this->socialAuthenticationAction->execute(new SocialAuthRequest($provider));

        return ApiResponse::success(new TokenResource($response));
    }
}
