<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

interface TableVisitRepository
{
    public function groupByCity(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByCountry(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByLanguage(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByBrowser(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByOperatingSystem(int $website_id, DatePeriod $datePeriod): Collection;

    public function groupByScreenResolution(int $website_id, DatePeriod $datePeriod): Collection;
}