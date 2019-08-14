<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;

final class AuthenticatedHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'email',
            'password' => 'string|min:8'
        ];
    }

    public function email(): ?string
    {
        return $this->get('email');
    }

    public function password(): ?string
    {
        return $this->get('password');
    }
}
