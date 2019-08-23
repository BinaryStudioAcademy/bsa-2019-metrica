<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\User;

interface UserRepository
{
    public function getById(int $id): User;

    public function save(User $user): User;

    public function getByEmail(string $email): ?User;

    public function activateUser(string $email): void;
}
