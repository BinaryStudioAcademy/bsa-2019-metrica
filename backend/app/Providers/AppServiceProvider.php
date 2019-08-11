<?php

namespace App\Providers;

use App\Repositories\Contracts\SessionRepository;
use App\Repositories\EloquentSessionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Contracts\UserRepository::class,
            \App\Repositories\EloquentUserRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\EloquentWebsiteRepository::class,
            \App\Repositories\WebsiteRepository::class
        );

        $this->app->bind(SessionRepository::class, EloquentSessionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
