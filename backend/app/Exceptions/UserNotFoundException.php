<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Throwable;

final class UserNotFoundException extends ModelNotFoundException implements ApiException
{
    private $message = "User not found.";

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->$message, $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function toArray(): array
    {
        return [
            'error' => [
                'message' => $this->message
            ]
        ];
    }
}
