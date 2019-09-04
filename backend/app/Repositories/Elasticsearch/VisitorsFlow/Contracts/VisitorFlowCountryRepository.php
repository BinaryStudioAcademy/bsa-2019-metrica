<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;

interface VisitorFlowCountryRepository
{
    public function save(Aggregate $tableAggregate): Aggregate;

    public function update(Aggregate $tableAggregate): Aggregate;

    public function getByCriteria(int $websiteId, string $url, int $level, string $country): ?CountryAggregate;
}
