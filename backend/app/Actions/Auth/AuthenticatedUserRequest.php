<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Http\Requests\AuthenticatedHttpRequest;

final class AuthenticatedUserRequest
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

    public static function fromRequest(AuthenticatedHttpRequest $request): self
    {
        return new static(
            $request->email(),
            $request->password()
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
