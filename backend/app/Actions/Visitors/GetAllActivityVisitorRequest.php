<?php

declare(strict_types=1);

namespace App\Actions\Visitors;

use App\Http\Requests\Visitor\GetAllActivityVisitorHttpRequest;

final class GetAllActivityVisitorRequest
{
    private $websiteId;

    private function __construct(int $websiteId)
    {
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(GetAllActivityVisitorHttpRequest $request): self
    {
        return new static($request->websiteId());
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
