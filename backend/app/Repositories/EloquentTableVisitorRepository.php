<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TableVisitorRepository;
use Illuminate\Database\Eloquent\Collection;

final class EloquentTableVisitorRepository implements TableVisitorRepository
{
    public function getAvgSessionsTimeByParameter(string $startDate, string $endDate, string $parameter): Collection
    {
        return new Collection();
    }
}