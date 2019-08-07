<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Repositories\Contracts\UserRepository;
use App\Entity\User;
use Tymon\JWTAuth\Facades\JWTAuth;

final class RegisterUserAction
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterRequest $request): RegisterResponse
    {
        $user = new User();
        $user->name = $request->getName();
        $user->email = $request->getEmail();
        $user->password = $request->getPassword();
        $this->userRepository->save($user);
        $token = JWTAuth::fromUser($user);

        return new RegisterResponse($token);
    }
}