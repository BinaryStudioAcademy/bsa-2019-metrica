<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\User\UpdateUserAction;
use App\Actions\User\UpdateUserRequest;
use App\Http\Requests\Auth\UpdateUserHttpRequest;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;

final class UserController extends Controller
{
    private $updateUserAction;

    public function __construct(UpdateUserAction $updateUserAction)
    {
        $this->updateUserAction = $updateUserAction;
    }

    public function update(UpdateUserHttpRequest $request): ApiResponse
    {
        $response = $this->updateUserAction->execute(UpdateUserRequest::fromRequest($request));

        return ApiResponse::success(new UserResource($response->user()));
    }
}
