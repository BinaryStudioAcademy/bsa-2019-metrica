<?php

namespace App\Providers;

use App\Repositories\Contracts\ChartPageTimingRepository;
use App\Repositories\Contracts\ChartVisitorRepository;
use App\Repositories\Contracts\ButtonVisitorsRepository;
use App\Repositories\Contracts\PageViews\ButtonDataRepository;
use App\Repositories\Contracts\ChartVisitorsRepository;
use App\Repositories\Contracts\GeoPositionRepository;
use App\Repositories\Contracts\PageRepository;
use App\Repositories\Contracts\PageViews\TableDataRepository;
use App\Repositories\Contracts\SessionRepository;
use App\Repositories\Contracts\SystemRepository;
use App\Repositories\Contracts\TablePageViewsRepository;
use App\Repositories\Contracts\TableVisitorsRepository;
use App\Repositories\Contracts\TableSessionRepository;
use App\Repositories\Contracts\TableVisitRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VisitorRepository;
use App\Repositories\Contracts\ChartVisitRepository;
use App\Repositories\Contracts\ChartSessionsRepository;
use App\Repositories\Contracts\VisitRepository;
use App\Repositories\Contracts\WebsiteRepository;
use App\Repositories\Contracts\PageViews\ChartDataRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowBrowserRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowCountryRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowDeviceRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\Contracts\VisitorFlowScreenRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\ElasticsearchVisitorFlowBrowserRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\ElasticsearchVisitorFlowCountryRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\ElasticsearchVisitorFlowDeviceRepository;
use App\Repositories\Elasticsearch\VisitorsFlow\ElasticsearchVisitorFlowScreenRepository;
use App\Repositories\EloquentChartPageTimingRepository;
use App\Repositories\EloquentChartVisitorRepository;
use App\Repositories\EloquentButtonVisitorsRepository;
use App\Repositories\PageViews\EloquentButtonDataRepository;
use App\Repositories\Contracts\TableNewVisitorsRepository;
use App\Repositories\EloquentChartVisitorsRepository;
use App\Repositories\EloquentGeoPositionRepository;
use App\Repositories\EloquentPageRepository;
use App\Repositories\EloquentSessionRepository;
use App\Repositories\EloquentSystemRepository;
use App\Repositories\EloquentTablePageViewsRepository;
use App\Repositories\EloquentTableVisitorsRepository;
use App\Repositories\EloquentTableSessionRepository;
use App\Repositories\EloquentTableVisitRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentVisitorRepository;
use App\Repositories\EloquentChartVisitRepository;
use App\Repositories\EloquentChartSessionsRepository;
use App\Repositories\EloquentVisitRepository;
use App\Repositories\EloquentWebsiteRepository;
use App\Repositories\EloquentTableNewVisitorsRepository;
use App\Repositories\PageViews\EloquentChartDataRepository;
use App\Repositories\PageViews\EloquentTableDataRepository;
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
        $this->registerTelescope();

        $this->app->bind(UserRepository::class, EloquentUserRepository::class);

        $this->app->bind(WebsiteRepository::class, EloquentWebsiteRepository::class);

        $this->app->bind(SessionRepository::class, EloquentSessionRepository::class);

        $this->app->bind(VisitorRepository::class, EloquentVisitorRepository::class);

        $this->app->bind(TableVisitorsRepository::class, EloquentTableVisitorsRepository::class);

        $this->app->bind(ChartVisitRepository::class, EloquentChartVisitRepository::class);

        $this->app->bind(ChartVisitorRepository::class, EloquentChartVisitorRepository::class);

        $this->app->bind(ChartSessionsRepository::class, EloquentChartSessionsRepository::class);

        $this->app->bind(ChartVisitorsRepository::class, EloquentChartVisitorsRepository::class);

        $this->app->bind(ButtonVisitorsRepository::class, EloquentButtonVisitorsRepository::class);

        $this->app->bind(TableSessionRepository::class, EloquentTableSessionRepository::class);

        $this->app->bind(TableVisitRepository::class, EloquentTableVisitRepository::class);

        $this->app->bind(ButtonDataRepository::class, EloquentButtonDataRepository::class);

        $this->app->bind(TableNewVisitorsRepository::class, EloquentTableNewVisitorsRepository::class);

        $this->app->bind(PageRepository::class, EloquentPageRepository::class);

        $this->app->bind(SystemRepository::class, EloquentSystemRepository::class);

        $this->app->bind(GeoPositionRepository::class, EloquentGeoPositionRepository::class);

        $this->app->bind(VisitRepository::class, EloquentVisitRepository::class);

        $this->app->bind(TablePageViewsRepository::class, EloquentTablePageViewsRepository::class);

        $this->app->bind(ChartDataRepository::class, EloquentChartDataRepository::class);

        $this->app->bind(ChartPageTimingRepository::class, EloquentChartPageTimingRepository::class);

        $this->app->bind(TableDataRepository::class, EloquentTableDataRepository::class);

        $this->app->bind(VisitorFlowCountryRepository::class, ElasticsearchVisitorFlowCountryRepository::class);

        $this->app->bind(VisitorFlowBrowserRepository::class, ElasticsearchVisitorFlowBrowserRepository::class);

        $this->app->bind(VisitorFlowDeviceRepository::class, ElasticsearchVisitorFlowDeviceRepository::class);

        $this->app->bind(VisitorFlowScreenRepository::class, ElasticsearchVisitorFlowScreenRepository::class);
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

    private function registerTelescope()
    {
        if (env('APP_ENV') === 'production') {
            return;
        }

        $this->app->register(TelescopeServiceProvider::class);
    }
}
