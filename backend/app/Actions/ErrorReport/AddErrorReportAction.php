<?php

declare(strict_types=1);

namespace App\Actions\ErrorReport;

use App\Entities\Error;
use App\Entities\Page;
use App\Repositories\Contracts\ErrorReport\ErrorReportRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Repositories\Contracts\WebsiteRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

final class AddErrorReportAction
{
    private $errorReportRepository;
    private $websiteRepository;
    private $pageRepository;
    private $visitorRepository;

    public function __construct(
        ErrorReportRepository $errorReportsRepository,
        PageRepository $pageRepository,
        WebsiteRepository $websiteRepository,
        VisitorRepository $visitorRepository
    ) {
        $this->errorReportRepository = $errorReportsRepository;
        $this->websiteRepository = $websiteRepository;
        $this->pageRepository = $pageRepository;
        $this->visitorRepository = $visitorRepository;
    }

    public function execute(AddErrorReportActionRequest $request): void
    {
        $visitorId = null;
        $websiteId = null;

        if ($request->token()) {
            JWTAuth::setToken(Str::after($request->token(), 'Bearer '));
            $visitorId = JWTAuth::getPayload()->get('visitor_id');
            $visitor = $this->visitorRepository->getById($visitorId);
            $websiteId = $visitor->website_id;
        }

        if(!$websiteId) {
            $websiteId = $this->websiteRepository
                ->getByTrackNumber((int) $request->trackingNumber())->id;
        }

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

        $this->errorReportRepository->save($error);
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

