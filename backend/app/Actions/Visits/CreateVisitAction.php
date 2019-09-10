<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visit;
use App\Events\VisitCreated;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\SystemRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Utils\HostIndicationsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Facades\JWTAuth;

final class CreateVisitAction
{
    private $visitorRepository;
    private $sessionRepository;
    private $pageRepository;
    private $systemRepository;
    private $geoPositionRepository;
    private $visitRepository;
    private $hostIndicationsService;

    public function __construct(
        VisitorRepository $visitorRepository,
        SessionRepository $sessionRepository,
        PageRepository $pageRepository,
        SystemRepository $systemRepository,
        GeoPositionRepository $geoPositionRepository,
        HostIndicationsService $hostIndicationsService,
        VisitRepository $visitRepository
    ) {
        $this->visitorRepository = $visitorRepository;
        $this->sessionRepository = $sessionRepository;
        $this->pageRepository = $pageRepository;
        $this->systemRepository = $systemRepository;
        $this->geoPositionRepository = $geoPositionRepository;
        $this->visitRepository = $visitRepository;
        $this->hostIndicationsService = $hostIndicationsService;
    }

    public function execute(CreateVisitRequest $request): void
    {
        JWTAuth::setToken(Str::after($request->token(), 'Bearer '));
        $visitorId = JWTAuth::getPayload()->get('visitor_id');
        $visitor = $this->visitorRepository->getById($visitorId);
        $this->visitorRepository->updateLastActivity($visitor);

        $page = $this->getOrCreatePage(
            $visitor->website_id,
            $request->pageTitle(),
            $request->page()
        );

        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());
        $system = $this->getOrCreateSystem(
            $agent->platform(),
            $request->device(),
            $agent->browser(),
            $request->resolutionHeight(),
            $request->resolutionWidth()
        );

        $geoPosition = $this->getOrCreateGeoPosition($request->ip());

        $session = $this->getOrCreateSession(
            $visitor->id,
            $page->id,
            $request->language(),
            $system->id
        );

        $visit = new Visit();

        $visit->visit_time = Carbon::now();
        $visit->ip_address = $request->ip();
        $visit->session_id = $session->id;
        $visit->page_id = $page->id;
        $visit->visitor_id = $visitor->id;
        $visit->geo_position_id = $geoPosition->id;
        $visit->page_load_time = $request->getPageLoadTime();
        $visit->server_response_time = $this->hostIndicationsService->getServerResponseTime($visitor->website->domain, $page->url);
        $visit->domain_lookup_time = $this->hostIndicationsService->getDomainLookupTime($visitor->website->domain);

        $this->visitRepository->save($visit);

        VisitCreated::dispatch($visit);
    }

    private function getOrCreatePage(int $websiteId, string $pageTitle, string $pageUrl): Page
    {
        $page = $this->pageRepository->getByParameters($websiteId, $pageTitle, $pageUrl);

        if ($page !== null) {
            return $page;
        }

        $page = new Page();

        $page->name = $pageTitle;
        $page->url = $pageUrl;
        $page->previews = 0;
        $page->website_id = $websiteId;

        return $this->pageRepository->save($page);
    }

    private function getOrCreateSystem(
        string $operatingSystem,
        string $device,
        string $browser,
        int $resolutionHeight,
        int $resolutionWidth
    ): System {
        $system = $this->systemRepository->getByParameters(
            $operatingSystem,
            $device,
            $browser,
            $resolutionHeight,
            $resolutionWidth
        );

        if ($system !== null) {
            return $system;
        }

        $system = new System();

        $system->os = $operatingSystem;
        $system->device = $device;
        $system->browser = $browser;
        $system->resolution_height = $resolutionHeight;
        $system->resolution_width = $resolutionWidth;

        return $this->systemRepository->save($system);
    }

    private function getOrCreateGeoPosition(string $ip): GeoPosition
    {
        $location = geoip($ip);
        $geoPosition = $this->geoPositionRepository->getByParameters($location->country, $location->city);

        if ($geoPosition !== null) {
            return $geoPosition;
        }

        $geoPosition = new GeoPosition();

        $geoPosition->country = $location->country;
        $geoPosition->city = $location->city;

        return $this->geoPositionRepository->save($geoPosition);
    }

    private function getOrCreateSession(
        int $visitorId,
        int $pageId,
        string $language,
        int $systemId
    ): Session {
        $session = $this->sessionRepository->lastActiveByVisitorId($visitorId);

        if ($session !== null) {
            $this->sessionRepository->updateEndSession($session);
            return $session;
        }

        $websiteId = $this->pageRepository->getById($pageId)->website_id;

        $session = new Session();

        $session->start_session = Carbon::now();
        $session->end_session = Carbon::now();
        $session->visitor_id = $visitorId;
        $session->entrance_page_id = $pageId;
        $session->language = $language;
        $session->system_id = $systemId;
        $session->website_id = $websiteId;

        return $this->sessionRepository->save($session);
    }
}
