<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\VisitorsFlow\BrowserFlowItem;
use App\DataTransformer\VisitorsFlow\BrowserItem;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class BrowserVisitorsFlowResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function presentBrowserViews(BrowserItem $item): array
    {
        return [
            'title' => $item->getTitle(),
            'count' => $item->getCount(),
        ];
    }

    public function presentBrowsersFlow(BrowserFlowItem $item): array
    {
        return [
            'browser' => $item->getBrowser(),
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
                        case 'browsers_views':
                            return $items->map(function (BrowserItem $item) {
                                return $this->presentBrowserViews($item);
                            });
                        case 'browsers_flow':
                            return $items->map(function (BrowserFlowItem $item) {
                                return $this->presentBrowsersFlow($item);
                            });
                    }
                }
            )
            ->all();
    }
}
