<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Http\Requests\Team\GetPermittedMenuItemsHttpRequest;

final class GetPermittedMenuItemsRequest
{
    private $memberId;
    private $websiteId;

    private function __construct(int $memberId, int $websiteId)
    {
        $this->memberId = $memberId;
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(GetPermittedMenuItemsHttpRequest $request, int $memberId): self
    {
        return new static(
            $memberId,
            $request->websiteId()
        );
    }

    public function memberId(): int
    {
        return $this->memberId;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
