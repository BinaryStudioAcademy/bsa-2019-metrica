<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Visits\ChartVisit;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class VisitResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(ChartVisit $chartVisit): array
    {
        return [
            'date' => $chartVisit->getDate(),
            'visits' => $chartVisit->getVisits(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (ChartVisit $chartVisit) {
                    return $this->present($chartVisit);
                }
            )
            ->all();
    }
}
