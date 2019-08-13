<?php

declare(strict_types=1);

namespace App\Actions\Pages;

use App\Repositories\Contracts\PageRepository;

final class GetPageViewsAction
{
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function execute(): GetPageViewsResponse
    {
        $views = $this->pageRepository->getPageViews();

        return new GetPageViewsResponse($views);
    }
}