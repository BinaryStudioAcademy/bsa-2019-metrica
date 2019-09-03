<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Http\Requests\Website\GetCurrentWebsiteHttpRequest;

final class GetcurrentWebsiteRequest
{
    private $id;

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function fromRequest(GetCurrentWebsiteHttpRequest $request): self
    {
        return new static($request->id());
    }
}
