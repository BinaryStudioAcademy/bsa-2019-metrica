<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Repositories\Contracts\UserRepository as IUserRepository;

final class UserRepository implements IUserRepository
{
    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }
}