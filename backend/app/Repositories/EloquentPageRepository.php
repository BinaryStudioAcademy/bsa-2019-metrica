<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\PageRepository;
use Illuminate\Database\Eloquent\Collection;

final class EloquentPageRepository implements PageRepository
{
    public function getPageViews(): Collection
    {
        return new Collection();
    }
}