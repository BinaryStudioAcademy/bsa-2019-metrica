<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;
use Illuminate\Support\Facades\Auth;

final class UpdateUserHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password',
        ];
    }

    public function id(): int
    {
        return Auth::id();
    }

    public function name(): string
    {
        return $this->get('name');
    }

    public function email(): string
    {
        return $this->get('email');
    }

    public function password()
    {
        return $this->get('password');
    }
}
