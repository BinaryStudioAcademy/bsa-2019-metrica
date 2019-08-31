<?php

declare(strict_types=1);

namespace App\Http\Requests\System;
use App\Http\Request\ApiFormRequest;

use App\Rules\{Timestamp, TimestampAfter};

final class FilterByPeriodHttpRequest extends ApiFormRequest
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
            ]
        ];
    }

    public function getStartDate(): string
    {
        return (string) $this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return (string) $this->get('filter')['endDate'];
    }
}
