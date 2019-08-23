<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface TableVisitorsRepository
{
    public function groupByCity(int $website_id, string $from, string $to): Collection;

    public function groupByCountry(int $website_id, string $from, string $to): Collection;

    public function groupByLanguage(int $website_id, string $from, string $to): Collection;

    public function groupByBrowser(int $website_id, string $from, string $to): Collection;

    public function groupByOperatingSystem(int $website_id, string $from, string $to): Collection;

    public function groupByScreenResolution(int $website_id, string $from, string $to): Collection;
}