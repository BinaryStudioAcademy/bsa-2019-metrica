<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Entities\Visitor;

final class CreateVisitorResponse
{
    private $visitorId;

    public function __construct(int $visitorId)
    {
        $this->visitorId = $visitorId;
    }

    public function visitorId(): int
    {
        return $this->visitorId;
    }
}