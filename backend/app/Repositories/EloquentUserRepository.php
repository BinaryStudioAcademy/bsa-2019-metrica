<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepository;
use App\Entities\User;

class EloquentUserRepository implements UserRepository
{
    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

}
