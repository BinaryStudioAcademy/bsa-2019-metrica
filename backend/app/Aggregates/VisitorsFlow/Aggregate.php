<?php
declare(strict_types=1);

namespace App\Aggregates\VisitorsFlow;

use App\Aggregates\VisitorsFlow\Values\PageValue;

abstract class Aggregate
{
    public $id;
    public $websiteId;
    public $url;
    public $title;
    public $prevPage;
    public $views;
    public $level;
    public $isLastPage;

    public function __construct(
        int $id,
        int $websiteId,
        string $url,
        string $title,
        int $views,
        int $level,
        bool $isLastPage,
        ?PageValue $prevPage
    )
    {
        $this->id = $id;
        $this->websiteId = $websiteId;
        $this->url = $url;
        $this->title = $title;
        $this->views = $views;
        $this->level = $level;
        $this->isLastPage = $isLastPage;
        $this->prevPage = $prevPage;

    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'websiteId' => $this->websiteId,
            'url' => $this->url,
            'title' => $this->title,
            'prevPage' => $this->prevPage === null ? null : [
                'id' => $this->prevPage->id,
                'url' => $this->prevPage->url
            ],
            'level' => $this->level,
            'views' => $this->views,
            'isLastPage' => $this->isLastPage,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }
}
