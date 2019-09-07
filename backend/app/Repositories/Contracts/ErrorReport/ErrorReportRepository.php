<?php

namespace App\Repositories\Contracts\ErrorReport;

use App\Entities\Error;

interface ErrorReportRepository
{
    public function save(Error $visitor): Error;
}
