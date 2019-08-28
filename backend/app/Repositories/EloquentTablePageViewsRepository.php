<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TablePageViewsRepository;
use Illuminate\Support\Facades\DB;

final class EloquentTablePageViewsRepository implements TablePageViewsRepository
{
    public function getCountPageViewsByPage(string $from, string $to, int $websiteId): array
    {
        $subQueryFirst = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQuerySecond = "SELECT id FROM pages WHERE website_id = :website_id";
        $subQueryThird = "SELECT page_id, session_id, start_session FROM ($subQueryFirst) AS visits" .
            " WHERE visits.start_session > :startDate AND visits.start_session < :endDate AND page_id IN ($subQuerySecond)";
        $query = DB::raw("SELECT v.page_id, COUNT(*) FROM ($subQueryThird) AS v GROUP BY v.page_id");

        $response = DB::select((string)$query, [
            'startDate' => $from,
            'endDate' => $to,
            'website_id' => $websiteId
        ]);

        return array_column($response, 'count', 'page_id');
    }

    public function getCountBounceRateByPage(string $from, string $to, int $websiteId): array
    {
        $subQueryFirst = "SELECT * FROM visits JOIN sessions ON visits.session_id = sessions.id";
        $subQuerySecond = "SELECT id FROM pages WHERE website_id = :website_id";
        $subQueryThird = "SELECT page_id, session_id, start_session FROM ($subQueryFirst) AS visits" .
            " WHERE visits.start_session > :startDate AND visits.start_session < :endDate AND page_id IN ($subQuerySecond)";
        $subQueryForth = "SELECT v.page_id, COUNT(*) FROM ($subQueryThird) AS v GROUP BY v.page_id, v.session_id";
        $subQueryFifth= "SELECT p.page_id FROM ($subQueryForth) AS p WHERE count < 2";
        $query = DB::raw("SELECT p.page_id, COUNT(*) FROM ($subQueryFifth) AS p GROUP BY p.page_id;");

        $response = DB::select((string)$query, [
            'startDate' => $from,
            'endDate' => $to,
            'website_id' => $websiteId
        ]);

        return array_column($response, 'count', 'page_id');
    }
}