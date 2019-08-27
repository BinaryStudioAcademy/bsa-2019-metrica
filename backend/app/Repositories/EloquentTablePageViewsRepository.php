<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TablePageViewsRepository;
use Illuminate\Support\Facades\DB;

final class EloquentTablePageViewsRepository implements TablePageViewsRepository
{
    public function getCountPageViewsByPage(string $from, string $to, int $pageId): int
    {
        return DB::table('visits')
            ->join('sessions', 'sessions.id', '=', 'visits.session_id')
            ->whereBetween('sessions.start_session', [$from, $to])
            ->where('visits.page_id', '=', $pageId)
            ->count();
    }

    public function getCountBounceRateByPage(string $from, string $to, int $pageId): int
    {
        $subQueryFirst = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQuerySecond = "SELECT page_id, session_id, start_session FROM ($subQueryFirst) AS visits " .
            "WHERE visits.start_session > :startDate AND visits.start_session < :endDate AND page_id = :page_id";
        $subQueryThird = "SELECT group_visits.page_id, group_visits.session_id, COUNT(*) FROM ($subQuerySecond) " .
            "AS group_visits GROUP BY group_visits.page_id, group_visits.session_id";
        $query = DB::raw("SELECT COUNT(*) FROM ($subQueryThird) AS group_count WHERE count < 2");

        $response = DB::select((string)$query, [
            'startDate' => $from,
            'endDate' => $to,
            'page_id' => $pageId
        ]);

        return array_column($response, 'count')[0];
    }
}