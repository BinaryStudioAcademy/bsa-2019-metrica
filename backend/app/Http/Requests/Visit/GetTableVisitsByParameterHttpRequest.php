<?php

declare(strict_types=1);

namespace App\Http\Requests\Visit;

use App\Http\Request\ApiFormRequest;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

final class GetTableVisitsByParameterHttpRequest extends ApiFormRequest
{
    public function rules()
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
                "in:city,country,language,browser,operating_system,screen_resolution"
            ],
        ];
    }

    public function startDate(): string
    {
        return $this->get('filter')['startDate'];
    }

    public function endDate(): string
    {
        return $this->get('filter')['endDate'];
    }

    public function parameter(): string
    {
        return $this->get('filter')['parameter'];
    }
}