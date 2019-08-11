<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\SessionRepository;
use Illuminate\Support\Collection;

class EloquentSessionRepository implements SessionRepository
{
    public function getCollection(): Collection
    {
        return collect([]);
    }
}