<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

final class GetCurrentUserAction
{
    public function execute(): GetCurrentUserResponse
    {
        return new GetCurrentUserResponse(Auth::user());
    }
}
