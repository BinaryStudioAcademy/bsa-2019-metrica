<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

use App\Aggregates\VisitorsFlow\Aggregate;
use App\Aggregates\VisitorsFlow\BrowserAggregate;
use App\DataTransformer\VisitorsFlow\ParameterFlowCollection;
use App\DataTransformer\VisitorsFlow\ParametersCollection;

interface VisitorFlowBrowserRepository extends VisitorFlowRepository
{
    public function save(Aggregate $browserAggregate): Aggregate;

    public function update(Aggregate $browserAggregate): Aggregate;

    public function getByCriteria(Criteria $criteria): ?BrowserAggregate;

    public function getViewsByEachBrowser(string $type, int $websiteId): ParametersCollection;

    public function getFlow(int $websiteId, int $level): ParameterFlowCollection;
}
