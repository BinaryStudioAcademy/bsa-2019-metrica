<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class BrowserCriteria implements  Criteria
{
    public $websiteId;
    public $url;
    public $level;
    public $browser;

    private function __construct(int $websiteId, string $url, int $level, string $browser)
    {
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->level = $level;
        $this->browser = $browser;
    }

    public static function getCriteria(int $websiteId, string $url, int $level, string $type)
    {
        return new static(
            $websiteId,
            $url,
            $level,
            $type
        );
    }
}
