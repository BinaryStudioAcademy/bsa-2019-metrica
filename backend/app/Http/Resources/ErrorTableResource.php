<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\ErrorReport\TableErrorReport;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class ErrorTableResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(TableErrorReport $table): array
    {
        return [
            'parameter' => $table->parameter(),
            'parameter_value' => $table->parameterValue(),
            'count' => $table->total(),
            'message' => $table->message(),
            'stack_trace' => $table->stackTrace(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (TableErrorReport $table) {
                    return $this->present($table);
                }
            )
            ->all();
    }
}