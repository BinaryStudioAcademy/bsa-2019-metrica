<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\VisitRepository;
use Illuminate\Database\Eloquent\Collection;

final class EloquentVisitRepository implements VisitRepository
{
    public function getPageViews(): Collection
    {
        return new Collection();
    }
}