<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use app\Actions\User\RegisterRequest;
use app\Actions\User\RegisterUserAction;
use App\Http\Requests\RegisterHttpRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class RegisterController extends Controller
{
    private $registerUserAction;

    public function __construct(RegisterUserAction $registerUserAction)
    {
        $this->registerUserAction = $registerUserAction;
    }

    protected function create(RegisterHttpRequest $request): JsonResponse
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
