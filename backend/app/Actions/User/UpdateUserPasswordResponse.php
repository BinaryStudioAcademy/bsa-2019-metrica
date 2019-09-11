<?php
declare(strict_types=1);

namespace App\Actions\User;

class UpdateUserPasswordResponse
{
    private $message = "New password was created. Please, sing in.";

    public function message(): string
    {
        return $this->message;
    }
}
