<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow\Contracts;

interface Criteria
{
    public function getCriteria(int $websiteId, string $url, int $level, string $type): array;
}
