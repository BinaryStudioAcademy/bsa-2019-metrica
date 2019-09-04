<?php

declare(strict_types=1);

namespace App\Http\Requests\Visitor;

use App\Http\Request\ApiFormRequest;

final class CreateVisitorHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function trackNumber(): string
    {
        return $this->header('X-Website');
    }
    public function origin(): string
    {
        return $this->header('Origin');
    }
}
