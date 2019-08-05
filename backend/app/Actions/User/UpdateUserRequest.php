<?php

declare(strict_types=1);

namespace App\Actions\User;

final class UpdateUserRequest
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct(
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

    public function id(): int
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function password(): ?string
    {
        return $this->password;
    }
}