<?php

declare(strict_types=1);

namespace App\DataTransformer\Visits;

final class PageViewsItem
{
    private $pageUrl;
    private $title;
    private $pageViewsCount;
    private $bounceRate;
    private $exitRate;

    public function __construct(
        string $pageUrl,
        string $title,
        int $pageViewsCount,
        float $bounceRate,
        float $exitRate
    ) {
        $this->bounceRate = $bounceRate;
        $this->exitRate = $exitRate;
        $this->pageUrl = $pageUrl;
        $this->pageViewsCount = $pageViewsCount;
        $this->title = $title;
    }

    public function pageUrl(): string
    {
        return $this->pageUrl;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function pageViewsCount(): int
    {
        return $this->pageViewsCount;
    }

    public function bounceRate(): float
    {
        return $this->bounceRate;
    }

    public function exitRate(): float
    {
        return $this->exitRate;
    }
}