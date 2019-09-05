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
        string $url,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        string $resolutionWidth,
        string $resolutionHeight,
        PageValue $prevPage
    )
    {
        parent::__construct($id, $websiteId, $url, $title, $views, $level, $isLastPage, $exitCount, $prevPage);
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
            (int)$result['websiteId'],
            (string)$result['url'],
            (string)$result['title'],
            (int)$result['views'],
            (int)$result['level'],
            (bool)$result['isLastPage'],
            (int)$result['exitCount'],
            (string)$result['resolution_width'],
            (string)$result['resolution_height'],
            new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            )
        );
    }

    public static function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowScreenRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ): Aggregate
    {
        return $visitorFlowScreenRepository->getByCriteria(
            ScreenCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $previousVisitUrl,
                $visit->session->system->resolution_width,
                $visit->session->system->resolution_height
            )
        );
    }
}
