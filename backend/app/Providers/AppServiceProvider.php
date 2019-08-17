<?php

namespace App\Providers;

use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\TableVisitorsRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Repositories\Contracts\ChartVisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\EloquentSessionRepository;
use App\Repositories\EloquentTableVisitorsRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentVisitorRepository;
use App\Repositories\EloquentChartVisitRepository;
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

        $this->app->bind(VisitorRepository::class, EloquentVisitorRepository::class);
        
        $this->app->bind(TableVisitorsRepository::class, EloquentTableVisitorsRepository::class);

        $this->app->bind(ChartVisitRepository::class, EloquentChartVisitRepository::class);
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
