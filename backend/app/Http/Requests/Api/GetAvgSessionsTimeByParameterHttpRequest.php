<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;
use App\Rules\Parameter;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

final class GetAvgSessionsTimeByParameterHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'required|array',
            'filter.start_date' => [
                'required',
                new Timestamp()
            ],
            'filter.end_date' => [
                'required',
                new Timestamp(),
                new TimestampAfter($this->get('filter')['start_date'])
            ],
            'filter.parameter' => [
                'required',
                'string',
                new Parameter()
            ]
        ];
    }

    public function startDate(): string
    {
        return $this->get('filter')['start_date'];
    }

    public function endDate(): string
    {
        return $this->get('filter')['end_date'];
    }

    public function parameter(): string
    {
        return $this->get('filter')['parameter'];
    }
}
