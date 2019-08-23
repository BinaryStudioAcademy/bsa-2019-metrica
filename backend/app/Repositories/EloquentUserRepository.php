<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Repositories\Contracts\UserRepository;

final class EloquentUserRepository implements UserRepository
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

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function activateUser(string $email): void
    {
        User::where('email', $email)->update(['is_activate' => 1]);
    }
}
