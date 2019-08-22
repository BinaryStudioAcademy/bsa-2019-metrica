<?php

declare(strict_types=1);

namespace App\Actions\Visits;

use App\Entities\GeoPosition;
use App\Entities\Page;
use App\Entities\Session;
use App\Entities\System;
use App\Entities\Visit;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\SystemRepository;
use App\Repositories\Contracts\VisitorRepository;
use Carbon\Carbon;
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

    public function __construct(
        VisitorRepository $visitorRepository,
        SessionRepository $sessionRepository,
        PageRepository $pageRepository,
        SystemRepository $systemRepository,
        GeoPositionRepository $geoPositionRepository
    ) {
        $this->visitorRepository = $visitorRepository;
        $this->sessionRepository = $sessionRepository;
        $this->pageRepository = $pageRepository;
        $this->systemRepository = $systemRepository;
        $this->geoPositionRepository = $geoPositionRepository;
    }

    public function execute(CreateVisitRequest $request): CreateVisitResponse
    {
        $token = Str::after($request->token(), 'Bearer ');
        JWTAuth::setToken($token);
        $visitorId = JWTAuth::getPayload()->get('visitor_id');

        $visitor = $this->visitorRepository->getById($visitorId);

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

        $visit = Visit::create([
            'visit_time' => Carbon::now(),
            'ip_address' => $request->ip(),
            'session_id' => $session->id,
            'page_id' => $page->id,
            'visitor_id' => $visitor->id,
            'geo_position_id' => $geoPosition->id
        ]);

        $visit->load('session', 'page', 'visitor', 'geo_position');

        return new CreateVisitResponse($visit);
    }

    private function getOrCreatePage(
        int $websiteId,
        string $pageTitle,
        string $pageUrl
    ): Page {
        $page = $this->pageRepository->getByParameters($websiteId, $pageTitle, $pageUrl);

        if ($page !== null) {
            return $page;
        }

        $page = Page::create([
            'name' => $pageTitle,
            'url' => $pageUrl,
            'previews' => 0,
            'website_id' => $websiteId
        ]);

        $page->load('website');

        return $page;
    }

    private function getOrCreateSystem(
        string $operatingSystem,
        string $device,
        string $browser,
        string $resolutionHeight,
        string $resolutionWidth
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

        return System::create([
            'os' => $operatingSystem,
            'device' => $device,
            'browser' => $browser,
            'resolution_height' => $resolutionHeight,
            'resolution_width' => $resolutionWidth
        ]);
    }

    private function getOrCreateGeoPosition(string $ip): GeoPosition
    {
        $location = geoip($ip);
        $geoPosition = $this->geoPositionRepository->getByParameters($location->country, $location->city);

        if ($geoPosition !== null) {
            return $geoPosition;
        }

        return GeoPosition::create([
            'country' => $location->country,
            'city' => $location->city
        ]);
    }

    private function getOrCreateSession(
        int $visitorId,
        int $pageId,
        string $language,
        int $systemId
    ): Session {
        $session = $this->sessionRepository->lastActiveByVisitorId($visitorId);

        if ($session !== null) {
            return $session;
        }

        $session = Session::create([
            'start_session' => Carbon::now(),
            'visitor_id' => $visitorId,
            'entrance_page_id' => $pageId,
            'language' => $language,
            'system_id' => $systemId
        ]);

        $session->load('visitor', 'page', 'system');

        return $session;
    }
}
