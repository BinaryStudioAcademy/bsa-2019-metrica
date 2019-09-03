<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

class CountryAggregate extends Aggregate
{
    public $country;

    public function __construct(
        int $websiteId,
        string $url,
        PageValue $nextPage,
        PageValue $prevPage,
        int $views,
        int $level,
        bool $isLastPage,
        string $country
    ) {
        parent::__construct($websiteId, $url, $nextPage, $prevPage, $views, $level, $isLastPage);
        $this->$country = $country;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['country' => $this->country]);
    }
}
