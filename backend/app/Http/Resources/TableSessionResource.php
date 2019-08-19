<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Contracts\ApiResponse;
use App\DataTransformer\Sessions\TableSession;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

final class TableSessionResource extends ResourceCollection implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(TableSession $tableSession): array
    {
        return [
            'parameter' => $tableSession->parameter(),
            'parameter_value' => $tableSession->parameterValue(),
            'total' => $tableSession->total(),
            'percentage' => $tableSession->percentage()
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(function (TableSession $tableSession) {
                return $this->present($tableSession);
            })
            ->all();
    }
}
