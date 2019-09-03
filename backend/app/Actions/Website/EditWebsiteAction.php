<?php

declare(strict_types=1);

namespace App\Actions\Website;

use App\Exceptions\WebsiteNotFoundException;
use App\Repositories\Contracts\WebsiteRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

final class EditWebsiteAction
{
    private $websiteRepository;

    public function __construct(
        WebsiteRepository $websiteRepository
    ) {
        $this->websiteRepository = $websiteRepository;
    }

    public function execute(EditWebsiteRequest $request): EditWebsiteResponse
    {
        try {
            $website = $this->websiteRepository->getById($request->getId());
        } catch (ModelNotFoundException $ex) {
            throw new WebsiteNotFoundException();
        }

        if (!auth()->user()->hasWebsite($request->getId())) {
            throw new AuthorizationException();
        }

        $website->name = $request->getName();
        $website->single_page = $request->getSinglePage();

        $this->websiteRepository->save($website);

        return new EditWebsiteResponse($website);
    }
}
