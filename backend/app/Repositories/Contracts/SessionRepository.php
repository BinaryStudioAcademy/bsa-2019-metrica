<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Session;
use Illuminate\Support\Collection;
use App\Actions\Sessions\CountSessionsFilter;
use App\Actions\Sessions\AverageSessionFilter;

interface SessionRepository
{
    public function getCollection(): Collection;

    public function countSessions(CountSessionsFilter $filter): int;

    public function getAvgSession(AverageSessionFilter $filter): Collection;

    public function lastActiveByVisitorId(string $visitorId): ?Session;
}
