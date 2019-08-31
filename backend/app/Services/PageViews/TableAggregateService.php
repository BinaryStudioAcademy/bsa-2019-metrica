<?php

declare(strict_types=1);

namespace App\Services\PageViews;

use App\Aggregates\PageViews\Values\PageValue;
use App\Aggregates\PageViews\TableAggregate;
use App\Repositories\Contracts\{
    WebsiteRepository,
    PageRepository,
    SessionRepository,
    VisitRepository
};
use App\Repositories\Elasticsearch\PageViews\ElasticsearchTableRepository;
use App\Entities\{
    Visit,
    Session
};
use Carbon\Carbon;

final class TableAggregateService
{
    private $websitesRepository;
    private $sessionsRepository;
    private $pagesRepository;
    private $aggregateRepository;
    private $visitsRepository;

    public function __construct(
        WebsiteRepository $websitesRepository,
        SessionRepository $sessionsRepository,
        PageRepository $pagesRepository,
        VisitRepository $visitsRepository,
        ElasticsearchTableRepository $aggregateRepository
    ) {
        $this->websitesRepository = $websitesRepository;
        $this->sessionsRepository = $sessionsRepository;
        $this->pagesRepository = $pagesRepository;
        $this->aggregateRepository = $aggregateRepository;
        $this->visitsRepository = $visitsRepository;
    }

    public function aggregate(Visit $visit): TableAggregate
    {
        $previousVisit = $this->getPreviousVisit($visit);
        $isOneInSession = $previousVisit === null;

        $tableAggregate = $this->createAggregate(
            $visit,
            $isOneInSession
        );

        $tableAggregate = $this->aggregateRepository->save($tableAggregate);

        if (!$isOneInSession) {
            $this->updateIsOneInSession($previousVisit);
        }
        $this->updateLastVisit($visit);

        return $tableAggregate;
    }

    private function updateLastVisit(Visit $visit)
    {
        $lastVisit = $this->getLastVisit($visit);
        
        if (!$lastVisit) {
            return;
        }
        
        $previousAggregate = $this->aggregateRepository->getById($lastVisit->id);

        $previousAggregate->updated_at = $visit->visit_time;
        $previousAggregate->isLast = false;

        $previousAggregate = $this->aggregateRepository->save($previousAggregate);
    }

    private function updateIsOneInSession(Visit $previousVisit): void
    {
        $aggregate = $this->aggregateRepository->getById($previousVisit->id);
        $aggregate->isOneInSession = false;

        $aggregate = $this->aggregateRepository->save($aggregate);
    }

    private function createAggregate(Visit $visit, bool $isOneInSession = true): TableAggregate
    {
        $page = $this->pagesRepository->getById($visit->page_id);
        $website = $this->websitesRepository->getById($page->website_id);
        $pageValue = new PageValue(
            $page->id,
            $page->url,
            $page->name,
            new Carbon($page->created_at)
        );
        $isLast = true;

        return new TableAggregate(
            $visit->id,
            $website->id,
            new Carbon($visit->visit_time),
            new Carbon($visit->visit_time),
            $isLast,
            $isOneInSession,
            $pageValue
        );
    }

    private function getLastVisit(Visit $currentVisit): ?Visit
    {
        return $this->visitsRepository
            ->findBySessionId($currentVisit->session_id)
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last(function (Visit $visit) use ($currentVisit) {
                return $currentVisit->id !== $visit->id;
            });
    }

    public function getPreviousVisit(Visit $visit): ?Visit
    {
        $page = $this->pagesRepository->getById($visit->page_id);
        $visitId = $visit->id;

        return $this->visitsRepository
            ->findBySessionId($visit->session_id)
            ->filter(function (Visit $visit) use ($page, $visitId) {
                return (
                    $visit->page_id === $page->id
                    &&
                    $visit->id !== $visitId
                );
            })
            ->sortBy(function (Visit $visit) {
                return (new Carbon($visit->visit_time))->getTimestamp();
            })
            ->last();
    }
}
