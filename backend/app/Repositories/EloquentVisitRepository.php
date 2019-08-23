<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Visit;
use App\Repositories\Contracts\VisitRepository;

final class EloquentVisitRepository implements VisitRepository
{
    public function save(Visit $visit): Visit
    {
        $visit->save();
        return $visit;
    }
}