<?php

namespace App\Providers;

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
        $this->app->bind(
            \App\Repositories\Contracts\EloquentTrackingInfoRepository::class,
            \App\Repositories\TrackingInfoRepository::class
        );
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
