<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\UserNotFoundException;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateUserAction
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUserRequest $request): UpdateUserResponse
    {
        try {
            $user = $this->userRepository->getById($request->id());
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundException();
        }

        $user->email = $request->email() ?: $user->email;
        $user->name = $request->name() ?: $user->name;
        $user->password = $request->password() ?: $user->password;

        $user = $this->userRepository->save($user);

        return new UpdateUserResponse($user);
    }
}