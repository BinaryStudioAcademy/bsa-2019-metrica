<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Http\Response;

final class ResetPasswordResponse
{
    private $message = "Email notification sent";

    public function message(): string
    {
        return $this->message;
    }

    public function status(): int
    {
        return Response::HTTP_CREATED;
    }
}
