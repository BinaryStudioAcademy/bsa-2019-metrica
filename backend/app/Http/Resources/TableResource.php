<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\TableFormat;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class TableResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(TableFormat $table): array
    {
        return [
            'parameter' => $table->parameter(),
            'parameter_value' => $table->parameterValue(),
            'total' => $table->total(),
            'percentage' => $table->percentage()
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (TableFormat $table) {
                    return $this->present($table);
                }
            )
            ->all();
    }
}
