<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class BrowserCriteria implements Criteria
{
    public $websiteId;
    public $targetUrl;
    public $level;
    public $parameter;
    public $prevPageUrl;

    private function __construct(int $websiteId, string $targetUrl, int $level, ?string $prevPageUrl, string $parameter)
    {
        $this->websiteId = $websiteId;
        $this->targetUrl = $targetUrl;
        $this->level = $level;
        $this->prevPageUrl = $prevPageUrl;
        $this->parameter = $parameter;
    }

    public static function getCriteria(int $websiteId, string $targetUrl, int $level, ?string $prevPageUrl, ...$params)
    {
        return new static(
            $websiteId,
            $targetUrl,
            $level,
            $prevPageUrl,
            $params[0]
        );
    }
}
