<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\User\UpdateUserAction;
use App\Actions\User\UpdateUserRequest;
use App\Http\Requests\UpdateUserHttpRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

final class AuthController extends Controller
{
    private $updateUserAction;

    public function __construct(UpdateUserAction $updateUserAction)
    {
        $this->middleware('auth:jwt', ['except' => []]);

        $this->updateUserAction = $updateUserAction;
    }

    public function update(UpdateUserHttpRequest $request): JsonResponse
    {
        $response = $this->updateUserAction->execute(
            new UpdateUserRequest(
                (int)$request->get('id'),
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            )
        );

        return response()->json(new UserResource($response->user()));
    }
}
