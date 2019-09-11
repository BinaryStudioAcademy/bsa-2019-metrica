<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

class ScreenFlowItem extends ParameterFlowItem
{
    private $resolutionWidth;
    private $resolutionHeight;

    public function __construct(array $item)
    {
        parent::__construct($item);
        $this->resolutionWidth = $item['resolution_width'];
        $this->resolutionHeight = $item['resolution_height'];
    }

    public function getParameter(): string
    {
        return "{$this->resolutionWidth}x{$this->resolutionHeight}";
    }
}
