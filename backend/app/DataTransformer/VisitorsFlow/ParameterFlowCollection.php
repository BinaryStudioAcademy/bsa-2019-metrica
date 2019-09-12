<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

use Illuminate\Support\Collection;

abstract class ParameterFlowCollection
{
    protected $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    abstract public function getCollection():Collection;
}
