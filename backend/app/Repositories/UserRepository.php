<?php

declare(strict_types=1);

namespace App\Repositories;

use App\User;
use App\Repositories\Contracts\UserRepository as IUserRepository;

final class UserRepository implements IUserRepository
{
    public function create(array $fields): User
    {
        return User::create($fields);
    }
}