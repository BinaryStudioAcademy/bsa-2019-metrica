<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Request\Api\Auth\LoginHttpRequest;
use App\Http\Resources\LoginResources;
use App\Http\Response\ApiResponse;

final class AuthController extends Controller
{
    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action
    )
    {
        $response = $action->execute(LoginRequest::fromRequest($httpRequest));
        return ApiResponse::success(new LoginResources($response));

    }
}
