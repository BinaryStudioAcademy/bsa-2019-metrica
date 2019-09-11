<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

class BrowserFlowItem extends ParameterFlowItem
{
    private $browser;

    public function __construct(array $item)
    {
        parent::__construct($item);
        $this->browser = $item['browser'];
    }

    public function getParameter(): string
    {
        return $this->browser;
    }
}
