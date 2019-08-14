<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TableVisitorsRepository
{
    public function groupByCity(string $from, string $to): Collection;

    public function groupByCountry(string $from, string $to): Collection;

    public function groupByLanguage(string $from, string $to): Collection;

    public function groupByBrowser(string $from, string $to): Collection;

    public function groupByOperatingSystem(string $from, string $to): Collection;

    public function groupByScreenResolution(string $from, string $to): Collection;

}