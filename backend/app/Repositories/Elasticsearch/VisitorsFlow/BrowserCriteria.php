<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class BrowserCriteria implements Criteria
{
    public $websiteId;
    public $url;
    public $level;
    public $browser;
    public $prevPageUrl;

    private function __construct(int $websiteId, string $url, int $level, string $browser, ?string $prevPageUrl)
    {
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->level = $level;
        $this->browser = $browser;
        $this->prevPageUrl = $prevPageUrl;
    }

    public static function getCriteria(int $websiteId, string $url, int $level, string $type, ?string $prevPageUrl)
    {
        return new static(
            $websiteId,
            $url,
            $level,
            $type,
            $prevPageUrl
        );
    }
}
