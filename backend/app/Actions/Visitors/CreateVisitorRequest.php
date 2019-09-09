<?php

declare(strict_types=1);

namespace App\Actions\Visitor;

use App\Http\Requests\Visitor\CreateVisitorHttpRequest;

final class CreateVisitorRequest
{
    private $trackNumber;

    private function __construct(int $trackNumber)
    {
        $this->trackNumber = $trackNumber;
    }

    public static function fromRequest(CreateVisitorHttpRequest $request): self
    {
        return new static(
            (int) $request->trackNumber()
        );
    }

    public function trackNumber(): int
    {
        return $this->trackNumber;
    }
}
