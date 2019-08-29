<?php

namespace App\Repositories\Contracts;

use App\Entities\Visit;

interface VisitRepository
{
    public function save(Visit $visit): Visit;

    public function findBySessionId(int $sessionId): Collection;
}
