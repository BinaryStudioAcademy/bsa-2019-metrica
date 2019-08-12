<?php

declare(strict_types=1);


namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface SessionRepository
{
    public function getCollection(): Collection;

    public function getAvgSession(?int $days = null): int;
}