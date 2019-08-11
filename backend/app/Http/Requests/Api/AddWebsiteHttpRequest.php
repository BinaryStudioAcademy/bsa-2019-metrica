<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddWebsiteHttpRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|unique:websites,name',
            'domain' => 'required|url|unique:websites,domain',
            'single_page' => 'required|boolean',
            'tracking_number' => 'required|integer'
        ];
    }

    public function name(): ?string
    {
        return $this->get('name');
    }

    public function domain(): ?string
    {
        return $this->get('domain');
    }

    public function single_page(): bool
    {
        return $this->get('single_page');
    }

    public function tracking_number(): ?int
    {
        return $this->get('tracking_number');
    }

}
