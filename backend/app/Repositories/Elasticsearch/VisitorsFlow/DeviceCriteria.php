<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class DeviceCriteria implements Criteria
{
    public $websiteId;
    public $url;
    public $level;
    public $device;
    public $prevPageUrl;

    private function __construct(int $websiteId, string $url, int $level, string $device, ?string $prevPageUrl)
    {
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->level = $level;
        $this->device = $device;
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

