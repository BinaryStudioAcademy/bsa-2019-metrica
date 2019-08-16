<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;

final class AuthenticatedHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8'
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

    public function messages()
    {
        parent::messages();
        return [
            'email.exists' => "User doesn't exist"
        ];

    }
}
