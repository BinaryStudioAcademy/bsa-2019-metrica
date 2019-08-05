<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Action\Auth\LoginAction;
use App\Action\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResources;

final class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(
         $httpRequest,
        LoginAction $action

    ) {
        try {
            $request = new LoginRequest(
                $httpRequest->email,
                $httpRequest->password
            );
            $response = $action->execute($request);
            return response()->json(new LoginResources($response), 200);
        } catch (\LogicException $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 400);
        }
    }
}
