<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Elasticsearch\VisitorsFlow\BrowserCriteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\DeviceCriteria;

class DeviceAggregate extends Aggregate
{
    public $device;

    public function __construct(
        int $id,
        int $websiteId,
        string $url,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        string $device,
        ?PageValue $prevPage
    )
    {
        parent::__construct($id, $websiteId, $url, $title, $views, $level, $isLastPage, $exitCount, $prevPage);
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
            (int)$result['websiteId'],
            (string)$result['url'],
            (string)$result['title'],
            (int)$result['views'],
            (int)$result['level'],
            (bool)$result['isLastPage'],
            (int)$result['exitCount'],
            (string)$result['device'],
            $result['prevPage'] === null ? null : new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            )
        );
    }

    public static function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowDeviceRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ): Aggregate
    {
        return $visitorFlowDeviceRepository->getByCriteria(
            DeviceCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $visit->session->system->device,
                $previousVisitUrl
            )
        );
    }
}
