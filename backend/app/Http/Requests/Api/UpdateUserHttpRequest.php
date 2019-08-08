<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Request\ApiFormRequest;

final class UpdateUserHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|min:3',
            'email' => 'email',
            'password' => 'string|min:8'
        ];
    }

    public function id(): int
    {
        return (int)$this->route('id');
    }

    public function name(): ?string
    {
        return $this->get('name');
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
