<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CountSessionsHttpRequest extends FormRequest
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
        return (int)$this->validated()['filter']['startDate'];
    }

    public function endDate(): int
    {
        return (int)$this->validated()['filter']['endDate'];
    }
}
