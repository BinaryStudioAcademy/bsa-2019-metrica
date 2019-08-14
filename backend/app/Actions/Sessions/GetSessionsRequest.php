<?php
declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Http\Requests\SessionHttpRequest;

final class GetSessionsRequest
{
    private $start_session;
    private $end_session;
    private $website_id;

    private function __construct(
        int $start_session,
        int $end_session,
        int $website_id
    ) {
        $this->start_session = $start_session;
        $this->end_session = $end_session;
        $this->website_id = $website_id;
    }

    public function getStartSession(): int
    {
        return $this->start_session;
    }

    public function getEndSession(): int
    {
        return $this->end_session;
    }

    public function getWebsiteId(): int
    {
        return $this->website_id;
    }

    public static function fromRequest(SessionHttpRequest $request): self
    {
        return new static(
            $request->startSession(),
            $request->websiteId(),
            $request->websiteId()
        );
    }
}