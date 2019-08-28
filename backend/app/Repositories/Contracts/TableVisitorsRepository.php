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

    public function getCountVisitorsGroupByCity(DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByCity(DatePeriod $datePeriod): Collection;

    public function getCountVisitorsGroupByCountry(DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByCountry(DatePeriod $datePeriod): Collection;

    public function getCountVisitorsGroupByLanguage(DatePeriod $datePeriod): Collection;

    public function getBounceRateRateGroupByLanguage(DatePeriod $datePeriod): Collection;

    public function getCountVisitorsGroupByBrowser(DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByBrowser(DatePeriod $datePeriod): Collection;

    public function getCountVisitorsGroupByOperatingSystem(DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByOperatingSystem(DatePeriod $datePeriod): Collection;

    public function getCountVisitorsRateGroupByScreenResolution(DatePeriod $datePeriod): Collection;

    public function getBounceRateGroupByScreenResolution(DatePeriod $datePeriod): Collection;
}