<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\DeviceCriteria;

class DeviceAggregate extends Aggregate
{
    public $device;

    public function __construct(
        int $id,
        int $websiteId,
        string $targetUrl,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        string $device,
        PageValue $prevPage
    ) {
        parent::__construct($id, $websiteId, $targetUrl, $title, $views, $level, $isLastPage, $exitCount, $prevPage);
        $this->device = $device;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['device' => $this->device]);
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
            (string)$result['device'],
            new PageValue(
                (int)$result['prev_page']['id'],
                (string)$result['prev_page']['source_url']
            )
        );
    }

    public function setPrevPage(PageValue $pageValue): void
    {
        $this->prevPage = $pageValue;
    }
}
