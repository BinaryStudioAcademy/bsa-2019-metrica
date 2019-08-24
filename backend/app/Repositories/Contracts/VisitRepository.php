<?php

namespace App\Repositories\Contracts;

use App\Entities\Visit;

interface VisitRepository
{
    public function save(Visit $visit): Visit;
}
