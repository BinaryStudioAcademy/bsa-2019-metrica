<?php

namespace App\Repositories\Contracts;

use App\Entities\User;

interface UserRepository
{
    public function getByEmail(string $email): ?User;
}
