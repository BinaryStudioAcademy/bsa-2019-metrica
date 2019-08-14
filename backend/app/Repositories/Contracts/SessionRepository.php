<?php

declare(strict_types=1);


namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Actions\Sessions\GetAvgSessionRequest;

interface SessionRepository
{
    public function getCollection(): Collection;

    public function getAvgSession(GetAvgSessionRequest $request): int;
}