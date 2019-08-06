<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Entities\User;

final class UpdateUserResponse
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