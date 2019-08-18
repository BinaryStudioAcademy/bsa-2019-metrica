<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\UserNotFoundException;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

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
            $user = $this->userRepository->getById($request->getId());
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundException();
        }

        $user->email = $request->getEmail($user->email);
        $user->name = $request->getName($user->name);
        if ($request->getPassword() !== "") {
            $user->password = Hash::make($request->getPassword());
        }

        $user = $this->userRepository->save($user);

        return new UpdateUserResponse($user);
    }
}