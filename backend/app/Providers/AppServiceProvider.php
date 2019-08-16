<?php

namespace App\Providers;

use App\Repositories\Contracts\ChartVisitorsRepository;
use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\EloquentChartVisitorsRepository;
use App\Repositories\EloquentSessionRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentVisitRepository;
use App\Repositories\EloquentWebsiteRepository;
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
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);

        $this->app->bind(WebsiteRepository::class, EloquentWebsiteRepository::class);

        $this->app->bind(SessionRepository::class, EloquentSessionRepository::class);

        $this->app->bind(
            \App\Repositories\Contracts\VisitorRepository::class,
            \App\Repositories\EloquentVisitorRepository::class
        );

        $this->app->bind(VisitRepository::class, EloquentVisitRepository::class);

        $this->app->bind(ChartVisitorsRepository::class, EloquentChartVisitorsRepository::class);
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
