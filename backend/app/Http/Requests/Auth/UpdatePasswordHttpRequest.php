<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Request\ApiFormRequest;

class UpdatePasswordHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|string',
            'token' => 'required|string'
        ];
    }

    public function getPassword(): string
    {
        return $this->get('password');
    }

    public function getToken(): string
    {
        return $this->get('token');
    }
}
