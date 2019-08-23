<?php


namespace App\Exceptions;


use App\Contracts\ApiException;
use Illuminate\Http\Response;

class UserActivatedException extends \Exception implements ApiException
{
    protected $message = "This account has already activated";

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message
        ];
    }

}
