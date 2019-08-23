<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterHttpRequest;

final class RegisterRequest
{
    private $name;
    private $email;
    private $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function fromHttpRequest(RegisterHttpRequest $request): RegisterRequest
    {
        return new static(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );
    }
}