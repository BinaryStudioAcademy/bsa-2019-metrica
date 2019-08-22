<?php

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

interface TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(DatePeriod $datePeriod, string $parameter): Collection;

    public function groupByLanguage(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByOs(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByBrowser(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByResolution(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByCity(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByCountry(int $website_id, DatePeriod $datePeriod): Collection;
}