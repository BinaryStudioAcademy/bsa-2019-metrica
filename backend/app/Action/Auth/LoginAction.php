<?php

declare(strict_types = 1);

namespace App\Action\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

final class LoginAction
{
    public function execute(LoginRequest $request): AuthenticationResponse
    {
        $token = Auth::attempt([
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ]);

        return new AuthenticationResponse(
            $token,
            'bearer'
        );
    }
}
