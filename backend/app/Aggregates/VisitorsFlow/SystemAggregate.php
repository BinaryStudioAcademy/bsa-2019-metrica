<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

class SystemAggregate extends Aggregate
{
    public $system;

    public function __construct(
        int $websiteId,
        string $url,
        PageValue $nextPage,
        PageValue $prevPage,
        int $views,
        int $level,
        bool $isLastPage,
        string $system
    ) {
        parent::__construct($websiteId, $url, $nextPage, $prevPage, $views, $level, $isLastPage);
        $this->system = $system;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['system' => $this->system]);
    }
}
