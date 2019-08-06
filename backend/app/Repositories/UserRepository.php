<?php

declare(strict_types=1);

namespace App\Repositories;

use App\User;
use App\Repositories\Contracts\UserRepository as EloquentUserRepository;

final class UserRepository implements EloquentUserRepository
{
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }
}