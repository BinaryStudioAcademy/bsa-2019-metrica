<?php
declare(strict_types=1);

namespace App\Actions\Sessions;

use App\Http\Requests\SessionHttpRequest;

final class GetAllSessionsRequest
{
    private $start_session;
    private $visitor_id;
    private $entrance_page_id;
    private $demographic_id;
    private $device_id;
    private $system_id;

    private function __construct(
        int $start_session,
        int $visitor_id,
        int $entrance_page_id,
        int $demographic_id,
        int $device_id,
        int $system_id
    ) {
        $this->start_session = $start_session;
        $this->visitor_id = $visitor_id;
        $this->entrance_page_id = $entrance_page_id;
        $this->demographic_id = $demographic_id;
        $this->device_id = $device_id;
        $this->system_id = $system_id;
    }

    public function getStartSession(): int
    {
        return $this->start_session;
    }

    public function getVisitorId(): int
    {
        return $this->visitor_id;
    }

    public function getEntrancePageId(): int
    {
        return $this->entrance_page_id;
    }

    public function getDemographicId(): int
    {
        return $this->demographic_id;
    }

    public function getDeviceId(): int
    {
        return $this->device_id;
    }

    public function getSystemId(): int
    {
        return $this->system_id;
    }

    public static function fromRequest(SessionHttpRequest $request): self
    {
        return new static(
            $request->startSession(),
            $request->visitorId(),
            $request->entrancePageId(),
            $request->demographicId(),
            $request->deviceId(),
            $request->systemId(),
        );
    }
}