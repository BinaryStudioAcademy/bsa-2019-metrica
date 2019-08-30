<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Entities\Session;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent;
use App\Actions\Sessions\CountSessionsFilter;
use App\Actions\Sessions\AverageSessionFilter;

interface SessionRepository
{
    public function getCollection(): Collection;

    public function save(Session $session): Session;

    public function countSessions(CountSessionsFilter $filter): int;

    public function getAvgSession(AverageSessionFilter $filter): Collection;

    public function lastActiveByVisitorId(int $visitorId): ?Session;

    public function updateEndSession(Session $session): void;

    public function getAvgSessionTimeGroupByCountry(string $startDate, string $endDate): Eloquent\Collection;

    public function getCountSessionsGroupByCountry(string $startDate, string $endDate): Eloquent\Collection;
}
