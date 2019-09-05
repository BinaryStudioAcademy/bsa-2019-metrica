<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\SpeedOverviewTableValue;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class SpeedOverviewTableResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(SpeedOverviewTableValue $tableValue): array
    {
        return [
            'parameter' => $tableValue->parameter(),
            'parameter_value' => $tableValue->parameterValue(),
            'average_time' => $tableValue->timing(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(function (SpeedOverviewTableValue $tableValue) {
                return $this->present($tableValue);
            })
            ->all();
    }
}
