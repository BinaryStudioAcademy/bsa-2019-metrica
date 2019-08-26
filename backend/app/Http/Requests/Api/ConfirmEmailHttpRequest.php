<?php


namespace App\Http\Requests\Api;

use App\Http\Request\ApiFormRequest;

class ConfirmEmailHttpRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'token' => 'required|string'
        ];
    }

    public function getToken():string
    {
        return $this->get('token');
    }
}
