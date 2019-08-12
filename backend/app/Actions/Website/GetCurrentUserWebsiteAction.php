<?php

declare(strict_types = 1);

namespace App\Actions\Website;

use Illuminate\Support\Facades\Auth;

final class GetCurrentUserWebsiteAction
{
    public function execute(): GetCurrentUserWebsiteResponse
    {
        $website = Auth::user()->getWebsite();

        if (!$website) {
            throw new UserWebsiteNotFoundException();
        }

        return new GetCurrentUserWebsiteResponse($website);
    }
}