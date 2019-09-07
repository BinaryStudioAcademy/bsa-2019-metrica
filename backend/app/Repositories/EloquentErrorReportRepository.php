<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Error;
use App\Repositories\Contracts\ErrorReport\ErrorReportRepository;

final class EloquentErrorReportRepository implements ErrorReportRepository
{
    public function save(Error $error): Error
    {
        $error->save();
        return $error;
    }
}
