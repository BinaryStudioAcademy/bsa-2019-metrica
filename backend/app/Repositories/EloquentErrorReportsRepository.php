<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Error;
use App\Repositories\Contracts\ErrorReports\ErrorReportsRepository;

final class EloquentErrorReportsRepository implements ErrorReportsRepository
{
    public function save(Error $error): Error
    {
        $error->save();
        return $error;
    }
}
