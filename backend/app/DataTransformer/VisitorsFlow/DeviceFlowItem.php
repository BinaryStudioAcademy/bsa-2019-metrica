<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

class DeviceFlowItem extends ParameterFlowItem
{
    private $device;

    public function __construct(array $item)
    {
        parent::__construct($item);
        $this->device = $item['device'];
    }

    public function getParameter(): string
    {
        return $this->device;
    }
}
