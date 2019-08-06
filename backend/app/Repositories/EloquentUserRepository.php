<?php

declare(strict_types=1);

namespace App\Repositories;

use App\User;
use App\Repositories\Contracts\UserRepository as IUserRepository;

final class EloquentUserRepository implements IUserRepository
{
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }
}