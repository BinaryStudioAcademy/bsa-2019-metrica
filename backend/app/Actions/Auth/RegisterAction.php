<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Repositories\Contracts\UserRepository;
use App\Entities\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

final class RegisterAction
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
        $user->password = Hash::make($request->getPassword());
        $this->userRepository->save($user);
        JWTAuth::factory()->setTTL(720);
        $token = JWTAuth::fromUser($user);

        $user->sendSuccessRegistrationNotification($user, $token);
        return new RegisterResponse($user->email);
    }
}
