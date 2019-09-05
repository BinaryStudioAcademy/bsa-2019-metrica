<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Elasticsearch\VisitorsFlow\BrowserCriteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;

class BrowserAggregate extends Aggregate
{
    public $browser;

    public function __construct(
        int $id,
        int $websiteId,
        string $url,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        string $browser,
        ?PageValue $prevPage
    )
    {
        parent::__construct($id, $websiteId, $url, $title, $views, $level, $isLastPage, $exitCount, $prevPage);
        $this->browser = $browser;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['browser' => $this->browser]);
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
            (string)$result['browser'],
            $result['prevPage'] === null ? null : new PageValue(
                (int)$result['prevPage']['id'],
                (string)$result['prevPage']['url']
            )
        );
    }

    public static function getPreviousAggregate(
        VisitorFlowRepository $visitorFlowBrowserRepository,
        Visit $visit,
        string $previousVisitUrl,
        int $level
    ): Aggregate
    {
        return $visitorFlowBrowserRepository->getByCriteria(
            BrowserCriteria::getCriteria(
                $visit->session->website_id,
                $visit->page->url,
                $level - 1,
                $visit->session->system->browser,
                $previousVisitUrl
            )
        );
    }
}
