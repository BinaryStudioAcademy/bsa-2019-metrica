<?php

namespace App\Repositories\Contracts;

use App\Entities\Visit;
use Illuminate\Support\Collection;

interface VisitRepository
{
    public function save(Visit $visit): Visit;

    public function findBySessionId(int $sessionId): Collection;
}
