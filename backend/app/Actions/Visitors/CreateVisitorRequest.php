<?php

declare(strict_types=1);

namespace App\Actions\Visitor;

use App\Http\Requests\Visitor\CreateVisitorHttpRequest;

final class CreateVisitorRequest
{
    private $trackNumber;
    private $origin;

    private function __construct(string $trackNumber, string $origin)
    {
        $this->trackNumber = $trackNumber;
        $this->origin = $origin;
    }

    public static function fromRequest(CreateVisitorHttpRequest $request): self
    {
        return new static(
            $request->trackNumber(),
            $request->origin()
        );
    }

    public function trackNumber(): string
    {
        return $this->trackNumber;
    }

    public function origin(): string
    {
        return $this->origin;
    }
}
