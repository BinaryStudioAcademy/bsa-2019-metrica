<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use app\Actions\User\RegisterRequest;
use app\Actions\User\RegisterUserAction;
use App\Http\Requests\RegisterHttpRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

final class RegisterController extends Controller
{
    private $registerUserAction;

    public function __construct(RegisterUserAction $registerUserAction)
    {
        $this->registerUserAction = $registerUserAction;
    }

    protected function create(RegisterHttpRequest $request): JsonResponse
    {
        $request = new RegisterRequest(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );
        $response = $this->registerUserAction->execute($request);

        return response()->json($response->getToken());
    }
}
