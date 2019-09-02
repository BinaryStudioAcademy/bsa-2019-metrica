<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;
use App\Utils\DatePeriod;

interface TableVisitorsRepository
{
    public function groupByCity(int $website_id, string $from, string $to): Collection;

    public function groupByCountry(int $website_id, string $from, string $to): Collection;

    public function groupByLanguage(int $website_id, string $from, string $to): Collection;

    public function groupByBrowser(int $website_id, string $from, string $to): Collection;

    public function groupByOperatingSystem(int $website_id, string $from, string $to): Collection;

    public function groupByScreenResolution(int $website_id, string $from, string $to): Collection;

    public function getCountVisitorsGroupByCity(DatePeriod $datePeriod, int $websiteId): Collection;

    public function getBounceRateGroupByCity(DatePeriod $datePeriod, int $websiteId): Collection;

    public function getCountVisitorsGroupByCountry(DatePeriod $datePeriod, int $websiteId): Collection;

    public function getBounceRateGroupByCountry(DatePeriod $datePeriod, int $websiteId): Collection;

    public function getCountVisitorsGroupByLanguage(int $website_id, DatePeriod $datePeriod): Collection;

    public function getBounceRateRateGroupByLanguage(int $website_id, DatePeriod $datePeriod): Collection;

    public function getCountVisitorsGroupByBrowser(int $website_id, DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByBrowser(int $website_id, DatePeriod $datePeriod): Collection;

    public function getCountVisitorsGroupByOperatingSystem(int $website_id, DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByOperatingSystem(int $website_id, DatePeriod $datePeriod): Collection;

    public function getCountVisitorsRateGroupByScreenResolution(int $website_id, DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByScreenResolution(int $website_id, DatePeriod $datePeriod): Collection;
}
