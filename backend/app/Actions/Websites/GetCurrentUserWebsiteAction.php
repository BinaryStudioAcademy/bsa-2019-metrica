<?php

declare(strict_types = 1);

namespace App\Actions\Websites;

use Illuminate\Support\Facades\Auth;

final class GetCurrentUserWebsiteAction
{
    public function execute(): GetCurrentUserWebsiteResponse
    {
        return new GetCurrentUserWebsiteResponse(Auth::user()->website());
    }
}