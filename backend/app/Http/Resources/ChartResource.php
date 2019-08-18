<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\ChartFormat;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class ChartResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(ChartFormat $chart): array
    {
        return [
            'date' => $chart->date(),
            'value' => $chart->value(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (ChartFormat $chart) {
                    return $this->present($chart);
                }
            )
            ->all();
    }
}
