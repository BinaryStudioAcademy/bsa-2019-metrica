<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\User\UpdateUserAction;
use App\Actions\User\UpdateUserPasswordAction;
use App\Actions\User\UpdateUserPasswordRequest;
use App\Actions\User\UpdateUserRequest;
use App\Http\Requests\Auth\UpdatePasswordHttpRequest;
use App\Http\Requests\Auth\UpdateUserHttpRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;

final class UserController extends Controller
{
    private $updateUserAction;
    private $updateUserPasswordAction;

    public function __construct(UpdateUserAction $updateUserAction, UpdateUserPasswordAction $updateUserPasswordAction)
    {
        $this->updateUserAction = $updateUserAction;
        $this->updateUserPasswordAction = $updateUserPasswordAction;
    }

    public function update(UpdateUserHttpRequest $request): ApiResponse
    {
        $response = $this->updateUserAction->execute(UpdateUserRequest::fromRequest($request));

        return ApiResponse::success(new UserResource($response->user()));
    }

    public function updatePassword(UpdatePasswordHttpRequest $request):ApiResponse
    {
        $response = $this->updateUserPasswordAction->execute(UpdateUserPasswordRequest::fromRequest($request));
        return  ApiResponse::success(new MessageResource($response));
    }
}
