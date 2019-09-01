<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\WidgetValue;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

final class MostPopularWidgetResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->resource);
    }

    public function present(WidgetValue $value): array
    {
        return [
            'name' => $value->name(),
            'percent' => $value->percent()
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (WidgetValue $value) {
                    return $this->present($value);
                }
            )
            ->all();
    }
}
