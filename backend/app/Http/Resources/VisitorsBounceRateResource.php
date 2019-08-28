<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use App\DataTransformer\Visitors\BounceRateVisitors;

final class VisitorsBounceRateResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(BounceRateVisitors $table): array
    {
        return [
            'parameter' => $table->parameter(),
            'parameter_value' => $table->parameterValue(),
            'bounce_rate' => $table->bounceRate(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (BounceRateVisitors $table) {
                    return $this->present($table);
                }
            )
            ->all();
    }
}
