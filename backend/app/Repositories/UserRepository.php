<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepository as IUserRepository;
use App\Entities\User;

class UserRepository implements IUserRepository
{
    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

}
