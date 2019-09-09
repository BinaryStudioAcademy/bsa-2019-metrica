<?php

declare(strict_types=1);

namespace App\Http\Requests\ErrorReport;

use App\Http\Request\ApiFormRequest;
use App\Rules\ErrorTableParameter;
use App\Rules\Timestamp;
use App\Rules\TimestampAfter;

final class GetErrorTableItemsHttpRequest extends ApiFormRequest
{
    const START_DATE = 'startDate';
    const END_DATE = 'endDate';
    const PARAMETER = 'parameter';
    const FILTER = 'filter';

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
                new TimestampAfter($this->get(self::FILTER)[self::START_DATE])
            ],
            'filter.parameter' => [
                'required',
                new ErrorTableParameter()
            ],
        ];
    }
    public function startDate(): string
    {
        return $this->get(self::FILTER)[self::START_DATE];
    }
    public function endDate(): string
    {
        return $this->get(self::FILTER)[self::END_DATE];
    }

    public function parameter(): string
    {
        return $this->get(self::FILTER)[self::PARAMETER];
    }
}