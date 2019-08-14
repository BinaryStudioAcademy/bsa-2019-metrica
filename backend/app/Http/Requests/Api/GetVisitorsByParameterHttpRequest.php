<?php
declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;

final class GetVisitorsByParameterHttpRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'filter' => 'required|array',
            'filter.start_date' => [
                'required',
                'date'
            ],
            'filter.end_date' => [
                'required',
                "after:{$this->get('filter')['start_date']}"
            ],
            'parameter' => [
                'required',
                "in:city,country,language,browser,operating_system,screen_resolution"
            ],
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
        return $this->get('parameter');
    }
}