<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UserByEmailNotFoundException extends ModelNotFoundException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('User with this email not found', $code, $previous);
    }
}