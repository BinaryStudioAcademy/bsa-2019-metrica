<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Laravel\Socialite\Facades\Socialite;

final class SocialRedirectAction
{
    public function execute(SocialAuthRequest $request): SocialRedirectResponse
    {
        $url = Socialite::with($request->provider())->stateless()->redirect()->getTargetUrl();

        return new SocialRedirectResponse($url);
    }
}
