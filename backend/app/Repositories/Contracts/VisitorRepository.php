<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface VisitorRepository
{
    public function all(): Collection;

    public function newest(): Collection;

    public function withSinglePageInactiveSession(): Collection;
}