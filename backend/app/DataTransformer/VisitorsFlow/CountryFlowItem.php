<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

class CountryFlowItem extends ParameterFlowItem
{
    private $country;

    public function __construct(array $item)
    {
        parent::__construct($item);
        $this->country = $item['country'];
    }

    public function getParameter(): string
    {
        return $this->country;
    }
}
