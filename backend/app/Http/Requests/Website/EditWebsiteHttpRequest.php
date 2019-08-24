<?php

declare(strict_types=1);

namespace App\Http\Requests\Website;

use App\Http\Request\ApiFormRequest;

final class EditWebsiteHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'single_page' => 'boolean',
        ];
    }

    public function name(): string
    {
        return $this->get('name');
    }

    public function singlePage(): bool
    {
        return $this->get('single_page')??false;
    }
}
