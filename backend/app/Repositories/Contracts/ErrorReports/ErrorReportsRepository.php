<?php

namespace App\Repositories\Contracts\ErrorReports;

use App\Entities\Error;

interface ErrorReportsRepository
{
    public function save(Error $visitor): Error;
}
