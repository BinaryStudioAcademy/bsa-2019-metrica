<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\CountryAggregate;
use App\DataTransformer\VisitorsFlow\ParameterFlowCollection;
use App\DataTransformer\VisitorsFlow\ParametersCollection;

interface VisitorFlowCountryRepository extends VisitorFlowRepository
{
    public function save(Aggregate $tableAggregate): Aggregate;

    public function update(Aggregate $tableAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?CountryAggregate;

    public function getFlow(int $websiteId, int $level): ParameterFlowCollection;

    public function getViewsByEachCountry(string $type, int $websiteId): ParametersCollection;
}
