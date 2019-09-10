<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;
use App\Entities\Visit;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowRepository;

abstract class Aggregate
{
    public $id;
    public $websiteId;
    public $targetUrl;
    public $title;
    public $prevPage;
    public $views;
    public $level;
    public $isLastPage;
    public $exitCount;

    public function __construct(
        int $id,
        int $websiteId,
        string $targetUrl,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        int $exitCount,
        PageValue $prevPage
    ) {
        $this->id = $id;
        $this->websiteId = $websiteId;
        $this->targetUrl = $targetUrl;
        $this->title = $title;
        $this->views = $views;
        $this->level = $level;
        $this->isLastPage = $isLastPage;
        $this->exitCount = $exitCount;
        $this->prevPage = $prevPage;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'website_id' => $this->websiteId,
            'target_url' => $this->targetUrl,
            'title' => $this->title,
            'prev_page' => [
                'id' => $this->prevPage->id,
                'source_url' => $this->prevPage->url
            ],
            'level' => $this->level,
            'views' => $this->views,
            'is_last_page' => $this->isLastPage,
            'exit_count' => $this->exitCount
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    abstract public static function fromResult(array $result): self;
}
