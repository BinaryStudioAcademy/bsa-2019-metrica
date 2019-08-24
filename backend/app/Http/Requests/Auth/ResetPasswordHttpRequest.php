<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Request\ApiFormRequest;

final class ResetPasswordHttpRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}