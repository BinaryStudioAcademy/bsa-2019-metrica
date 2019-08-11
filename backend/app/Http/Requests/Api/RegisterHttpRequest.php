<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Request\ApiFormRequest;

final class RegisterHttpRequest extends ApiFormRequest
{
    public function getName(): string
    {
        return $this->get('name');
    }

    public function getEmail(): string
    {
        return $this->get('email');
    }

    public function getPassword(): string
    {
        return $this->get('password');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|string',
        ];
    }
}
