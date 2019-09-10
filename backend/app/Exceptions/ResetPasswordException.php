<?php
declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\ApiException;
use Illuminate\Http\Response;

class ResetPasswordException extends \Exception implements ApiException
{
    protected $message = "Something wrong happened with password or token!";

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($this->message, $code, $previous);
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
