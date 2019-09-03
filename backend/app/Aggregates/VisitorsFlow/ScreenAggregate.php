<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

class ScreenAggregate extends Aggregate
{
    public $resolutionWidth;
    public $resolutionHeight;

    public function __construct(
        int $websiteId,
        string $url,
        PageValue $nextPage,
        PageValue $prevPage,
        int $views,
        int $level,
        bool $isLastPage,
        int $resolutionWidth,
        int $resolutionHeight
    ) {
        parent::__construct($websiteId, $url, $nextPage, $prevPage, $views, $level, $isLastPage);
        $this->resolutionWidth = $resolutionWidth;
        $this->resolutionHeight = $resolutionHeight;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'resolution_width' => $this->resolutionWidth,
            'resolution_height' => $this->resolutionHeight
        ]);
    }
}
