<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\VisitorsFlow\ParameterFlowItem;
use App\DataTransformer\VisitorsFlow\ParameterItem;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class VisitorsFlowResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function presentParameterViews(ParameterItem $item): array
    {
        return [
            'title' => $item->getTitle(),
            'count' => $item->getCount(),
        ];
    }

    public function presentVisitorsFlow(ParameterFlowItem $item): array
    {
        return [
            "{$item->getParameter()}" => $item->getParameter(),
            'target_url' => $item->getTargetUrl(),
            'level' => $item->getLevel(),
            'views' => $item->getViews(),
            'exit_count' => $item->getExitCount(),
            'source_url' => $item->getSourceUrl()
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (Collection $items, $key) {
                    switch ($key) {
                        case 'parameter_views':
                            return $items->map(function (ParameterItem $item) {
                                return $this->presentParameterViews($item);
                            });
                        case 'visitors_flow':
                            return $items->map(function (ParameterFlowItem $item) {
                                return $this->presentVisitorsFlow($item);
                            });
                    }
                }
            )
            ->all();
    }
}
