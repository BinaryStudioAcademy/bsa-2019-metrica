<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Contracts\ApiResponse as ApiResponseContract;
use App\Exceptions\TokenCouldNotCreate;
use App\Exceptions\UserByEmailNotFoundException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthenticatedUserAction
{

    public function execute(AuthenticatedUserRequest $request): ApiResponseContract
    {
        try {
            $token = JWTAuth::attempt([
                'email' => $request->getEmail(),
                'password' => $request->getPassword()
            ]);

            if (!$token) {
                throw new UserByEmailNotFoundException();
            }
        } catch (JWTException $exception) {
            throw new TokenCouldNotCreate();
        }

        return  new AuthenticationResponse($token);
    }

}
