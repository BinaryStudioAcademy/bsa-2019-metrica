<?php

declare(strict_types = 1);

namespace App\Actions\Auth;
use App\Exceptions\UserByEmailNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\Contracts\UserRepository;


final class SendResetPasswordLinkAction
{
    private $userRepository;

    private const FAIL_CODE = 500;
    private const SUCCESS_CODE = 201;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ResetPasswordRequest $request): ?ResetPasswordResponse
    {

        $user = $this->userRepository->getByEmail($request->getEmail());

        if (!$user) {
            throw new UserByEmailNotFoundException();
        }

        try {
            JWTAuth::factory()->setTTL(30);
            $token = JWTAuth::fromUser($user);

        } catch (JWTException $e) {
            return new ResetPasswordResponse(self::FAIL_CODE);
        }

        $user->sendPasswordResetNotification($token);

        return new ResetPasswordResponse(self::SUCCESS_CODE);
    }
}