<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Http\Request\Api\Auth\LoginHttpRequest;

final class LoginRequest
{
    private $email;
    private $password;

    public function __construct(
        string $email,
        string $password
    ) {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(LoginHttpRequest $request): self
    {
        return new static(
            $request->getEmail(),
            $request->getPassword()
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
