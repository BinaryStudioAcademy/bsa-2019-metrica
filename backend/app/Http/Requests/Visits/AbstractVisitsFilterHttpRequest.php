<?php
declare(strict_types=1);

namespace App\Http\Requests\Visits;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractVisitsFilterHttpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "filter" => [
                'required',
                'array',
                'min:1'
            ],
        ];
    }

    public function getFilterArray(): array
    {
        return $this->get('filter');
    }
}
