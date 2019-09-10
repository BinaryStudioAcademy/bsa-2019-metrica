<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\ScreenAggregate;
use App\DataTransformer\VisitorsFlow\ParameterFlowCollection;
use App\DataTransformer\VisitorsFlow\ParametersCollection;

interface VisitorFlowScreenRepository extends VisitorFlowRepository
{
    public function save(Aggregate $browserAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?ScreenAggregate;

    public function getFlow(int $websiteId, int $level): ParameterFlowCollection;

    public function getViewsByEachScreen(int $websiteId): ParametersCollection;
}
