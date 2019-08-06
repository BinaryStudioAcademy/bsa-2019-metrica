<?php

declare(strict_types=1);

namespace app\Actions\User;

use app\Repositories\Contracts\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterUserAction
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterRequest $request): RegisterResponse
    {
        $user = $this->userRepository->create([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ]);
        $token = JWTAuth::fromUser($user);

        return new RegisterResponse($token);
    }
}