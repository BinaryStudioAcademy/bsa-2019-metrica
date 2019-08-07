<?php

namespace App\Repositories\Contracts;

use App\Entities\User;

interface UserRepository
{
    public function getById(int $id): User;

    public function save(User $user): User;

    public function getByEmail(string $email): ?User;
}
