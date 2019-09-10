<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\ScreenCriteria;

class ScreenAggregate extends Aggregate
{
    public $resolutionWidth;
    public $resolutionHeight;

    public function __construct(
        int $id,
        int $websiteId,
        string $targetUrl,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        string $resolutionWidth,
        string $resolutionHeight,
        PageValue $prevPage
    ) {
        parent::__construct($id, $websiteId, $targetUrl, $title, $views, $level, $isLastPage, $exitCount, $prevPage);
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

    public static function fromResult(array $result): Aggregate
    {
        return new static(
            (int)$result['id'],
            (int)$result['website_id'],
            (string)$result['target_url'],
            (string)$result['title'],
            (int)$result['views'],
            (int)$result['level'],
            (bool)$result['is_last_page'],
            (int)$result['exit_count'],
            (string)$result['resolution_width'],
            (string)$result['resolution_height'],
            new PageValue(
                (int)$result['prev_page']['id'],
                (string)$result['prev_page']['source_url']
            )
        );
    }
}
