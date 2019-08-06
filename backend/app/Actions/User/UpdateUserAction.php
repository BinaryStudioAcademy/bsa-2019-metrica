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
            $user = $this->userRepository->getById($request->getId());
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundException();
        }

        $user->email = $request->getEmail($user->email);
        $user->name = $request->getName($user->name);
        $user->password = $request->getPassword($user->password);

        $user = $this->userRepository->save($user);

        return new UpdateUserResponse($user);
    }
}