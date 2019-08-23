<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Entities\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

final class SocialAuthenticationAction
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(SocialAuthRequest $request): SocialAuthenticationResponse
    {
        $socialUser = Socialite::with($request->provider())->stateless()->user();

        $user = $this->userRepository->getByEmail($socialUser->email);

        if ($user === null) {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => Hash::make(Str::random(8))
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return new SocialAuthenticationResponse($token);
    }
}
