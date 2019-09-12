<?php

declare(strict_types=1);

namespace App\Http\Requests\Visit;

use App\Http\Request\ApiFormRequest;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

final class GetVisitsDensityHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return  [
            'filter' => 'required|array',
            'filter.startDate' => [
                'required',
                new Timestamp()
            ],
            'filter.endDate' => [
                'required',
                new Timestamp(),
                new TimestampAfter($this->get('filter')['startDate'])
            ],
            'filter.timeZone' => [
                'string'
            ],
        ];
    }

    public function startDate(): string
    {
        return (string) $this->get('filter')['startDate'];
    }

    public function endDate(): string
    {
        return (string) $this->get('filter')['endDate'];
    }

    public function getTimeZone(): string
    {
        $timeZone = $this->get('filter')['timeZone']??'+00:00';
        return (string) $timeZone;
    }
}
