<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Exceptions\TokenCouldNotCreate;
use App\Exceptions\UnauthenticatedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthenticatedUserAction
{
    public function execute(AuthenticatedUserRequest $request): AuthenticationResponse
    {
        try {
            $token = JWTAuth::attempt([
                'email' => $request->getEmail(),
                'password' => $request->getPassword(),
                'is_activate' => 1
            ]);

            if (!$token) {
                throw new UnauthenticatedException();
            }
        } catch (JWTException $exception) {
            throw new TokenCouldNotCreate();
        }

        return new AuthenticationResponse($token);
    }
}
