<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entity\User;
use App\Repositories\Contracts\UserRepository;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): User
    {
        $user->save();

        return $user;
    }
}