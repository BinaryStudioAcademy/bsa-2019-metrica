<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;

interface VisitorFlowCountryRepository extends VisitorFlowRepository
{
    public function save(Aggregate $tableAggregate): Aggregate;

    public function update(Aggregate $tableAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?CountryAggregate;
}
