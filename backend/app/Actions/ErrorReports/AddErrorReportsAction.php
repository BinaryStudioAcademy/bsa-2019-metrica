<?php

declare(strict_types=1);

namespace App\Actions\ErrorReports;

use App\Entities\Error;
use App\Entities\Page;
use App\Repositories\Contracts\ErrorReports\ErrorReportsRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\WebsiteRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

final class AddErrorReportsAction
{
    private $errorReportsRepository;
    private $websiteRepository;
    private $pageRepository;

    public function __construct(
        ErrorReportsRepository $errorReportsRepository,
        PageRepository $pageRepository,
        WebsiteRepository $websiteRepository
    ) {
        $this->errorReportsRepository = $errorReportsRepository;
        $this->websiteRepository = $websiteRepository;
        $this->pageRepository = $pageRepository;
    }

    public function execute(AddErrorReportsActionRequest $request)
    {
        $visitorId = null;
        if ($request->token()) {
            JWTAuth::setToken(Str::after($request->token(), 'Bearer '));
            $visitorId = JWTAuth::getPayload()->get('visitor_id');
        }

        $websiteId = $this->websiteRepository
            ->getByTrackNumber($request->trackingNumber())->id;

        $page = $this->getOrCreatePage(
            $websiteId,
            $request->pageTitle(),
            $request->page()
        );

        $error = new Error();

        $error->message = $request->message();
        $error->stack_trace = $request->stackTrace();
        $error->visitor_id = $visitorId;
        $error->page_id = $page->id;

        $this->errorReportsRepository->save($error);
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
}

