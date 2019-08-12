<?php

declare(strict_types=1);

namespace App\Actions\Pages;

use App\Actions\GetByIdRequest;
use App\Exceptions\PageNotFoundException;
use App\Repositories\Contracts\PageRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GetPageViewsAction
{
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function execute(GetByIdRequest $request): GetPageViewsResponse
    {
        try {
            $page = $this->pageRepository->getPageById($request->getId());
        }catch (ModelNotFoundException $exception){
            throw new PageNotFoundException();
        }

        return new GetPageViewsResponse($this->pageRepository->getPageViews($page));
    }
}