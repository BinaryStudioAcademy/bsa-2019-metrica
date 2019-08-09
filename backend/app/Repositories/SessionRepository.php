<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository as SessionRepositoryInterface;
use Illuminate\Support\Collection;

class SessionRepository implements SessionRepositoryInterface
{
    public function all(): Collection
    {
        return collect([]);
    }
}