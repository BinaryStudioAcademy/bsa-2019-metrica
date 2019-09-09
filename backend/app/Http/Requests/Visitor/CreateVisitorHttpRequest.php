<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;

use App\Http\Request\ApiFormRequest;

final class CreateVisitorHttpRequest extends ApiFormRequest
{
    const HEADER_X_WEBSITE = 'X-Website';

    public function rules(): array
    {
        return [];
    }

    public function trackNumber(): string
    {
        return $this->header(self::HEADER_X_WEBSITE);
    }
}
