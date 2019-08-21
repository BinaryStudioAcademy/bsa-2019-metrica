<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TableNewVisitorsRepository
{
    public function groupVisitorsByParameter(int $website_id, string $from, string $to, string $parameter): Collection;
}