<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\ApiResponse;

class AvgSession extends JsonResource implements ApiResponse
{
    public function toArray($request): array
    {
        return [
            'avg_session' => $this->convertSecondsToHoursMinutesSeconds($this->resource)
        ];
    }

    private function convertSecondsToHoursMinutesSeconds(int $seconds): array
    {
        $keys = ['h', 'm', 's'];
        $values = explode(':', gmdate("H:i:s", $seconds));

        return array_combine($keys, $values);
    }
}
