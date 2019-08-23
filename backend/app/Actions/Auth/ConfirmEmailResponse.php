<?php


namespace App\Actions\Auth;


use Illuminate\Http\Response;

class ConfirmEmailResponse
{
    private $message = 'You have been successfully registered';

    public function message(): string
    {
        return $this->message;
    }

    public function status(): int
    {
        return Response::HTTP_NO_CONTENT;
    }
}
