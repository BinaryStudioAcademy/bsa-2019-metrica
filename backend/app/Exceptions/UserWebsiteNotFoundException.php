<?php

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UserWebsiteNotFoundException extends ModelNotFoundException implements ApiException
{
    protected $message = 'Current user website not found';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->message, $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message
        ];
    }
}