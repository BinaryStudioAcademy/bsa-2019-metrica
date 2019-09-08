<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

class BrowserFlowItem implements ParameterFlowItem
{
    private $browser;
    private $targetUrl;
    private $views;
    private $exitCount;
    private $level;
    private $sourceUrl;

    public function __construct(array $item)
    {
        $this->browser = $item['browser'];
        $this->targetUrl = $item['target_url'];
        $this->views = $item['views'];
        $this->level = $item['level'];
        $this->exitCount = $item['exit_count'];
        $this->sourceUrl = $item['prev_page']['source_url'];
    }

    public function getParameter(): string
    {
        return $this->browser;
    }

    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function getExitCount(): int
    {
        return $this->exitCount;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }
}
