<?php

declare(strict_types=1);

namespace App\Http\Requests\Website;

use App\Http\Request\ApiFormRequest;

final class AddWebsiteHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:websites,name',
            'domain' => 'required|string|max:255|unique:websites,domain',
            'single_page' => 'boolean',
        ];
    }

    public function name(): string
    {
        return $this->get('name');
    }

    public function domain(): string
    {
        return $this->get('domain');
    }

    public function singlePage(): bool
    {
        return $this->get('single_page') ?? false;
    }
}
