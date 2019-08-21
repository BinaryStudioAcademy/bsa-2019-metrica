<?php

declare(strict_types=1);

namespace App\Http\Requests\Session;

use App\Http\Request\ApiFormRequest;

final class CountSessionsHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter.startDate' => 'required|integer',
            'filter.endDate' => 'required|integer',
        ];
    }

    public function startDate()
    {
        return $this->validated()['filter']['startDate'];
    }

    public function endDate()
    {
        return $this->validated()['filter']['endDate'];
    }
}
