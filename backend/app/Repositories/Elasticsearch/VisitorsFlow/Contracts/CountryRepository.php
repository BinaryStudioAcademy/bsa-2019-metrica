<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;

interface CountryRepository
{
    public function save(Aggregate $tableAggregate): Aggregate;

    public function update(Aggregate $tableAggregate): Aggregate;

    public function getByParams(int $websiteId, string $url, int $level): ?CountryAggregate;
}
