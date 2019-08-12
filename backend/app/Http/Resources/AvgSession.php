<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvgSession extends JsonResource
{
    public function toArray(int $avgSession): array
    {
        return [
            'avg_session' => $this->convertSecondsToHoursMinutesSeconds($avgSession)
        ];
    }

    private function convertSecondsToHoursMinutesSeconds(int $seconds): array
    {
        $keys = ['h', 'm', 's'];
        $values = explode(':', gmdate("H:i:s", $seconds));

        return array_combine($keys, $values);
    }
}
