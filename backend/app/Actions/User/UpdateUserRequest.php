<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Http\Requests\Auth\UpdateUserHttpRequest;

final class UpdateUserRequest
{
    private $id;
    private $name;
    private $email;
    private $password;

    private function __construct(
        int $id,
        ?string $name,
        ?string $email,
        ?string $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(UpdateUserHttpRequest $request): self
    {
        return new static(
            $request->id(),
            $request->name(),
            $request->email(),
            $request->password()
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(string $default = null): ?string
    {
        return $this->name ?? $default;
    }

    public function getEmail(string $default = null): ?string
    {
        return $this->email ?? $default;
    }

    public function getPassword(string $default = null): ?string
    {
        return $this->password ?? $default;
    }
}