<?php

declare(strict_types = 1);

namespace App\Action\Auth;
use App\Exceptions\UserByEmailNotFoundException;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


final class SendResetPasswordLinkAction
{
    private $userRepository;

    private const FAIL_CODE = 500;
    private const SUSSESS_CODE = 201;
    private const SUCCESS_STATUS = 'success';
    private const FAIL_STATUS = 'fail';

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
            return new ResetPasswordResponse(self::FAIL_STATUS, self::FAIL_CODE);
        }

        $user->sendPasswordResetNotification($token);

        return new ResetPasswordResponse(self::SUCCESS_STATUS, self::SUSSESS_CODE);
    }
}