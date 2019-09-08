<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class BrowserCriteria implements Criteria
{
    public $websiteId;
    public $targetUrl;
    public $level;
    public $browser;
    public $prevPageUrl;

    private function __construct(int $websiteId, string $targetUrl, int $level, ?string $prevPageUrl, string $browser)
    {
        $this->websiteId = $websiteId;
        $this->targetUrl = $targetUrl;
        $this->level = $level;
        $this->browser = $browser;
        $this->prevPageUrl = $prevPageUrl;
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
