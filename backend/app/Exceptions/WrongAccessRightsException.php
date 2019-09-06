<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Exception;
use Illuminate\Http\Response;
use Throwable;

final class WrongAccessRightsException extends Exception implements ApiException
{
    public function __construct(
        $message = 'You do not have rights to access this resource.',
        $code = 0,
        Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_FORBIDDEN;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message
        ];
    }
}