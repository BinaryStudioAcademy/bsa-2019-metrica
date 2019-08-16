<?php

declare(strict_types=1);


namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Actions\Sessions\CountSessionsFilter;

interface SessionRepository
{
    public function getCollection(): Collection;

    public function countSessions(CountSessionsFilter $filter): int;
}