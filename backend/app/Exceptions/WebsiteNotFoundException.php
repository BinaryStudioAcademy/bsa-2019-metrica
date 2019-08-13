<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Throwable;

final class WebsiteNotFoundException extends ModelNotFoundException implements ApiException
{
    public function __construct($message = 'Website not found.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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
