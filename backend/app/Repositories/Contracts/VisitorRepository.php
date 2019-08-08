<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface VisitorRepository
{
    public function all(): Collection;
}