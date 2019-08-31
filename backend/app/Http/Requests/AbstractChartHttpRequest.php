<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Request\ApiFormRequest;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

abstract class AbstractChartHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'required|array',
            'filter.startDate' => [
                'required',
                new Timestamp()
            ],
            'filter.endDate' => [
                'required',
                new Timestamp(),
                new TimestampAfter((string)$this->getStartDate())
            ],
            'filter.period' => [
                'required',
                'integer'
            ]
        ];
    }

    public function getStartDate(): string
    {
        return (string)$this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return (string)$this->get('filter')['endDate'];
    }

    public function getPeriod(): string
    {
        return (string)$this->get('filter')['period'];
    }
}
