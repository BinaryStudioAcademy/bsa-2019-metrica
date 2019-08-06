<?php

declare(strict_types=1);

namespace app\Actions\User;

use app\Repositories\Contracts\UserRepository;
use App\User;
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
        $user = $this->userRepository->save(
            User::create([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
            ])
        );
        $token = JWTAuth::fromUser($user);

        return new RegisterResponse($token);
    }
}