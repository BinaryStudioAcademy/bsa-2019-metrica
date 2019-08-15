<?php


namespace App\Http\Requests\Visitors;


use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractVisitorsFilterHttpRequest extends FormRequest
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
