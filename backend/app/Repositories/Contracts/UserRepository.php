<?php

declare(strict_types=1);

namespace app\Repositories\Contracts;

use App\Entities\User;

interface UserRepository
{
    public function getById(int $id): User;

    public function save(User $user): User;
}