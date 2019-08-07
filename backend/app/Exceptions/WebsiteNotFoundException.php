<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Throwable;

final class WebsiteNotFoundException extends ModelNotFoundException implements ApiException
{
    private $message = "Website not found.";

    public function __construct($message = null, $code = 0, Throwable $previous = null)
    {
        $this->message = $message??$this->$message;
        parent::__construct($this->$message, $code, $previous);
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
