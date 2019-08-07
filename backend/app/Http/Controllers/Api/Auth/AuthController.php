<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\AuthenticatedUserAction;
use App\Actions\Auth\AuthenticatedUserRequest;
use App\Contracts\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticatedHttpRequest;
use App\Http\Response\ApiResponse;

final class AuthController extends Controller
{
    public function login(
        AuthenticatedHttpRequest $request,
        AuthenticatedUserAction $action
    )
    {
        try {
            $response = $action->execute(AuthenticatedUserRequest::fromRequest($request));
        } catch (ApiException $exception) {
            return ApiResponse::error($exception);
        }
        return ApiResponse::success($response);

    }
}
