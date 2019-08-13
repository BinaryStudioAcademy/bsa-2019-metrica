<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface VisitorRepository
{
    public function all(): Collection;

    public function countAll(): int;

    public function newest(): Collection;

    public function countSinglePageInactiveSessionBetweenDate(string $from, string $to): int;
}