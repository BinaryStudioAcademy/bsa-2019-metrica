<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Exception;
use Illuminate\Http\Response;
use Throwable;

final class WebsiteDomainNotValidException extends Exception implements ApiException
{
    protected $message = "The site domain is invalid for this tracking number.";

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