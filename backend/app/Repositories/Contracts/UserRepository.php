<?php

declare(strict_types=1);

namespace app\Repositories\Contracts;

use App\Entity\User;

interface UserRepository
{
    public function save(User $user): User;
}