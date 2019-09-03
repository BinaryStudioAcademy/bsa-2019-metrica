<?php

declare(strict_types=1);

namespace App\Http\Requests\Website;

use App\Http\Request\ApiFormRequest;

final class GetCurrentWebsiteHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer|unique:websites,id'
        ];
    }

    public function id(): int
    {
        return (int)$this->get('id') ?? 0;
    }
}
