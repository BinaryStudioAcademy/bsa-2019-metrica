<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Entities\User;

final class GetAuthenticatedUserResponse
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): User
    {
        return $this->user;
    }
}
