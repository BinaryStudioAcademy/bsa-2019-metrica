<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\TablePageViewsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\DataTransformer\Visits\PageViewsItem;

final class EloquentTablePageViewsRepository implements TablePageViewsRepository
{
    private function getCountPageViewsByPage(string $from, string $to, int $websiteId): array
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

    private function getCountBounceRateByPage(string $from, string $to, int $websiteId): array
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

    private function getCountExitRateByPage(string $from, string $to, int $websiteId): array
    {
        $subQueryFirst = '(SELECT MAX(v.visit_time), v.page_id, v.session_id
                            FROM visits AS v
                            JOIN sessions AS s ON v.session_id = s.id
                            WHERE s.start_session BETWEEN ? AND ?
                                AND s.website_id = ?
                            GROUP BY v.session_id, v.page_id)';

        $sql = "SELECT COUNT(page_id) as count, page_id
                FROM $subQueryFirst as p
                GROUP BY page_id";

        $response = DB::select($sql, [$from, $to, $websiteId]);

        return array_column($response, 'count', 'page_id');
    }

    private function getPageNamesAndTitles(string $from, string $to, int $websiteId): array
    {
        $subQueryFirst = "(SELECT v.*, s.start_session, p.*
                           FROM visits v
                           JOIN sessions s ON v.session_id = s.id
                           JOIN pages p ON v.page_id = p.id)";

        $subQuerySecond = "(SELECT page_id, session_id, start_session, url, name
                            FROM $subQueryFirst AS n
                            WHERE n.start_session BETWEEN ? AND ?
                                AND n.website_id = ?)";

        $sql = "SELECT DISTINCT(page_id), url, name
                FROM $subQuerySecond AS q";

        $result = DB::select($sql, [$from, $to, $websiteId]);

        $response = [];

        foreach ($result as $page) {
            $response[$page->page_id] = [
                'title' => $page->name,
                'url' => $page->url,
            ];
        }

        return $response;
    }


    public function getPageViewsTableData(string $from, string $to, int $websiteId): Collection
    {
        $allViews = $this->getCountPageViewsByPage($from, $to, $websiteId);
        $bounced = $this->getCountBounceRateByPage($from, $to, $websiteId);
        $exitRates = $this->getCountExitRateByPage($from, $to, $websiteId);
        $namesAndtitles = $this->getPageNamesAndTitles($from, $to, $websiteId);

        $tableData = new Collection();
        foreach ($allViews as $pageId => $totalViews) {
            $tableData->add(new PageViewsItem(
                $namesAndtitles[$pageId]['url'],
                $namesAndtitles[$pageId]['title'],
                $totalViews,
                array_key_exists($pageId, $bounced) ? (int)($bounced[$pageId]/$totalViews*100) : 0,
                array_key_exists($pageId, $exitRates) ? (int)$exitRates[$pageId] : 0
            ));
        }

        return $tableData;
    }

}