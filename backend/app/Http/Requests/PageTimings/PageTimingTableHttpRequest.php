<?php

namespace App\Http\Requests\PageTimings;

use App\Rules\Timestamp;
use App\Rules\TimestampAfter;
use App\Http\Request\ApiFormRequest;

final class PageTimingTableHttpRequest extends ApiFormRequest
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
                new TimestampAfter($this->get('filter')['startDate'])
            ],
            'filter.parameter' => [
                'required',
                'in:country,page,browser'
            ]
        ];
    }

    public function getStartDate(): string
    {
        return $this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return $this->get('filter')['endDate'];
    }

    public function getParameter(): string
    {
        return $this->get('filter')['parameter'];
    }
}
