<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LoginRequest;
use app\Actions\User\RegisterRequest;
use App\Actions\User\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Request\Api\Auth\LoginHttpRequest;
use App\Http\Requests\RegisterHttpRequest;
use App\Http\Resources\LoginResources;
use App\Http\Response\ApiResponse;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    private $registerUserAction;

    public function __construct(RegisterUserAction $registerUserAction)
    {
        $this->registerUserAction = $registerUserAction;
    }

    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action
    )
    {
        $response = $action->execute(LoginRequest::fromRequest($httpRequest));
        return ApiResponse::success(new LoginResources($response));

    }

    public function register(RegisterHttpRequest $request): JsonResponse
    {
        $request = RegisterRequest::fromHttpRequest($request);
        $response = $this->registerUserAction->execute($request);
        $token = $response->getToken();

        return response([
            "data" => [ "token" => $token ],
            "meta" => []
        ]);
    }
}
