<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Http\Requests\Team\GetTeamHttpRequest;

final class GetTeamRequest
{
    private $websiteId;

    private function __construct(int $websiteId)
    {
        $this->websiteId = $websiteId;
    }
    public static function fromRequest(GetTeamHttpRequest $request): self
    {
        return new static($request->websiteId());
    }
    public function websiteId(): int
    {
        return $this->websiteId;
    }
}