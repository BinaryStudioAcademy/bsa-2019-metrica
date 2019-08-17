<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DataTransformer\Sessions\TableSession;
use App\Entities\Session;
use App\Repositories\Contracts\TableSessionRepository;
use App\Utils\DatePeriod;
use Illuminate\Support\Collection;

final class EloquentTableSessionRepository implements TableSessionRepository
{
    public function getAvgSessionsTimeByParameter(DatePeriod $datePeriod, string $parameter): Collection
    {
        return Session::whereDateBetween($datePeriod)
            ->avgSessionsTime()
            ->groupByParameter($parameter)
            //->calculateAvgSessionTimePercentage()
            ->get()
            ->map(function (Session $session) use ($parameter) {
                return new TableSession(
                    $parameter,
                    $session->parameter_value,
                    $session->avg_session_time,
                    2//$session->percentage
                );
            });
    }
}