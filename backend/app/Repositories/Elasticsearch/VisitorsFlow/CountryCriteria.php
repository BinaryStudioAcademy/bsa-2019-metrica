<?php
declare(strict_types=1);

namespace App\Repositories\Elasticsearch\VisitorsFlow;

use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\Criteria;

class CountryCriteria implements Criteria
{
    public $websiteId;
    public $url;
    public $level;
    public $country;
    public $prevPageUrl;

    private function __construct(int $websiteId, string $url, int $level, string $country, ?string $prevPageUrl)
    {
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->level = $level;
        $this->country = $country;
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
