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

    private function __construct(int $websiteId, string $url, int $level, string $country)
    {
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->level = $level;
        $this->country = $country;
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
