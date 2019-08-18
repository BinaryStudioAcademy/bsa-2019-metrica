<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\ApiResponse;
use App\DataTransformer\Sessions\ChartSessions;
use Illuminate\Support\Collection;

final class GetSessionsResource extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return $this->presentCollection($this->collection);
    }

    public function present(ChartSessions $chartSessions): array
    {
        return [
            'date' => $chartSessions->getDate(),
            'sessions' => $chartSessions->getSessions(),
        ];
    }

    public function presentCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (ChartSessions $chartSessions) {
                    return $this->present($chartSessions);
                }
            )
            ->all();
    }
}