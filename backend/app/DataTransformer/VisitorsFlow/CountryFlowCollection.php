<?php
declare(strict_types=1);

namespace App\DataTransformer\VisitorsFlow;

use Illuminate\Support\Collection;

class CountryFlowCollection extends ParameterFlowCollection
{
    public function getCollection(): Collection
    {
        return collect($this->collection)->map(function ($item) {
            return new CountryFlowItem($item['_source']);
        });
    }
}
