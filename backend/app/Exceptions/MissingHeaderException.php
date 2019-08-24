<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Exception;
use Illuminate\Http\Response;
use Throwable;

final class MissingHeaderException extends Exception implements ApiException
{
    protected $message;

    public function __construct(string $header = "", int $code = 0, Throwable $previous = null)
    {
        $this->message = "{$header} header is required.";
        parent::__construct($this->message, $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message
        ];
    }
}
