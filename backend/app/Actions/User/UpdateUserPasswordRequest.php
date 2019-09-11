<?php
declare(strict_types=1);

namespace App\Actions\User;

use App\Http\Requests\Auth\UpdatePasswordHttpRequest;

final class UpdateUserPasswordRequest
{
    private $token;
    private $password;

    private function __construct(string $token, string $password)
    {
        $this->token = $token;
        $this->password = $password;
    }

    public static function fromRequest(UpdatePasswordHttpRequest $request): self
    {
        return new static(
            $request->getToken(),
            $request->getPassword()
        );
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
