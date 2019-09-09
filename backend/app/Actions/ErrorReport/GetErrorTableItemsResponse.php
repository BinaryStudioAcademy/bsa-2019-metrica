<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use Illuminate\Support\Collection;

class GetErrorTableItemsResponse
{
    private $errors;

    public function __construct(Collection $errors)
    {
        $this->errors = $errors;
    }

    public function getGroupedErrors(): Collection
    {
        return $this->errors;
    }
}
