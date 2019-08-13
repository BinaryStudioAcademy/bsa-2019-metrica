<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Request\ApiFormRequest;

final class GetAvgSessionHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'filter.startDate' => 'required|integer',
            'filter.endDate' => 'required|integer',
        ];
    }

    public function startDate(): int
    {
        return (int)$this->get('filter.startDate');
    }

    public function endDate(): int
    {
        return (int)$this->get('filter.endDate');
    }
}
