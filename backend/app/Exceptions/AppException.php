<?php


namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Http\Response;

class AppException extends \Exception implements ApiException
{
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
