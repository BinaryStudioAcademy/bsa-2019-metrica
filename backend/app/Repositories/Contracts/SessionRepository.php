<?php

declare(strict_types=1);


namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Actions\Sessions\GetAvgSessionRequest;
use App\Actions\Sessions\AverageSessionFilter;

interface SessionRepository
{
    public function getCollection(): Collection;

    public function getAvgSession(AverageSessionFilter $filter): Collection;
}