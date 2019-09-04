<?php

declare(strict_types=1);

namespace App\Actions\Teams;

use App\Http\Requests\Team\InviteTeamMemberHttpRequest;

final class InviteTeamMemberRequest
{
    private $email;
    private $websiteId;

    private function __construct(string $email, int $websiteId)
    {
        $this->email = $email;
        $this->websiteId = $websiteId;
    }

    public static function fromRequest(InviteTeamMemberHttpRequest $request): self
    {
        return new static(
            $request->email(),
            $request->websiteId()
        );
    }

    public function email(): string
    {
        return $this->email;
    }

    public function websiteId(): int
    {
        return $this->websiteId;
    }
}
