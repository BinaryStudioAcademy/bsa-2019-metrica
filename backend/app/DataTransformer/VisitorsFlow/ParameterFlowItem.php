<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

class ParameterFlowItem
{
    private $targetUrl;
    private $views;
    private $exitCount;
    private $level;
    private $sourceUrl;

    public function __construct(array $item)
    {
        $this->targetUrl = $item['target_url'];
        $this->views = $item['views'];
        $this->level = $item['level'];
        $this->exitCount = $item['exit_count'];
        $this->sourceUrl = $item['prev_page']['source_url'];
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
