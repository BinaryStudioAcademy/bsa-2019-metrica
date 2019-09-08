<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

use Illuminate\Support\Collection;

class ParameterFlowCollection
{
    private $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function getCollection():Collection
    {
        return collect($this->collection)->map(function ($item) {
            return new ParameterFlowItem($item['_source']);
        });
    }
}
