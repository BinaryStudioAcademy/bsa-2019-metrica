<?php

declare(strict_types = 1);

namespace App\Http\Request\Api\Auth;

use App\Http\Request\ApiFormRequest;

final class LoginHttpRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            $this->getEmail() => 'required|email',
            $this->getPassword() => 'required|min:6|string',
        ];
    }

    public function getEmail()
    {
        return $this->get('email');
    }

    public function getPassword()
    {
        return $this->get('password');
    }


    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.email' => 'Bad email!',
            'password.required' => 'Password is required!'
        ];
    }
}
