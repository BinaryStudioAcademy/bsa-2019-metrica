<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Action\Auth\LoginAction;
use App\Action\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Request\Api\Auth\LoginHttpRequest;
use App\Http\Resources\LoginResources;

final class AuthController extends Controller
{
    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action
    )
    {
        $request = new LoginRequest(
            $httpRequest->email,
            $httpRequest->password
        );

        $response = $action->execute($request);

        return response()->json(new LoginResources($response), 200);

    }
}
