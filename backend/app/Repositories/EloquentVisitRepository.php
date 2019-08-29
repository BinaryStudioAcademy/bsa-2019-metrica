<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Visit;
use App\Repositories\Contracts\VisitRepository;
use Illuminate\Support\Collection;

final class EloquentVisitRepository implements VisitRepository
{
    public function save(Visit $visit): Visit
    {
        $visit->save();

        return $visit;
    }

    public function findBySessionId(int $sessionId): Collection
    {
        return Visit::where('session_id', $sessionId)->get();
    }
}