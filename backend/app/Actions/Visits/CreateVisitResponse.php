<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Entities\Visit;

final class CreateVisitResponse
{
    private $visit;

    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    public function visit(): Visit
    {
        return $this->visit;
    }
}
