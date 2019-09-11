<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Elasticsearch\VisitorsFlow\BrowserCriteria;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;

class BrowserAggregate extends Aggregate
{
    public $parameter;

    public function __construct(
        int $id,
        int $websiteId,
        string $targetUrl,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        string $parameter,
        PageValue $prevPage
    ) {
        parent::__construct($id, $websiteId, $targetUrl, $title, $views, $level, $isLastPage, $exitCount, $prevPage);
        $this->parameter = $parameter;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['parameter' => $this->parameter]);
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
            (string)$result['parameter'],
            new PageValue(
                (int)$result['prev_page']['id'],
                (string)$result['prev_page']['source_url']
            )
        );
    }
}
