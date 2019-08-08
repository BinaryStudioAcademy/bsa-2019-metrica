<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AuthenticatedHttpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
