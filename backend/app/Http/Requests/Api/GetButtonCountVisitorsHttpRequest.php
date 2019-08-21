<?php

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

class GetButtonCountVisitorsHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter' => 'required|array',
            "filter.startDate" => [
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
        return $this->get('filter')['startDate'];
    }

    public function getEndDate(): string
    {
        return $this->get('filter')['endDate'];
    }
}
