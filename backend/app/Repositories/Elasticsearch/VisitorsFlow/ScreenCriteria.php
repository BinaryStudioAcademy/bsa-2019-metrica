<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class ScreenCriteria implements Criteria
{
    public $websiteId;
    public $url;
    public $level;
    public $resolutionWidth;
    public $resolutionHeight;
    public $prevPageUrl;

    private function __construct(
        int $websiteId,
        string $url,
        int $level,
        ?string $prevPageUrl,
        string $resolutionWidth,
        string $resolutionHeight
    )
    {
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->level = $level;
        $this->resolutionWidth = $resolutionWidth;
        $this->resolutionHeight = $resolutionHeight;
        $this->prevPageUrl = $prevPageUrl;
    }

    public static function getCriteria(int $websiteId, string $url, int $level, ?string $prevPageUrl, ...$params)
    {
        return new static(
            $websiteId,
            $url,
            $level,
            $prevPageUrl,
            $params[0],
            $params[1]
        );
    }
}
